<?php

namespace App\Filament\Student\Pages;

use App\Domain\Content\Models\Exercise;
use App\Domain\Content\Models\Lesson;
use App\Modules\Assessment\Domain\Models\UserAnswer;
use App\Modules\ErrorIntelligence\Application\Services\DetectErrorPatternService;
use App\Modules\Learning\Domain\Models\UserProgress;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class LessonPlayer extends Page
{
    protected string $view = 'filament.student.pages.lesson-player';

    protected static ?string $title = 'Lesson';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'lesson-player';

    public ?Lesson $lesson = null;

    public array $selectedAnswers = [];

    public array $feedback = [];

    public array $adaptiveRecommendation = [];

    public function mount(): void
    {
        $lessonId = request()->query('lesson');

        $this->lesson = Lesson::query()
            ->with([
                'module',
                'contentBlocks',
                'exercises',
                'exercises.neuroTags',
                'exercises.errorPatterns',
            ])
            ->findOrFail($lessonId);
    }

    public function getTitle(): string
    {
        return $this->lesson?->title ?? 'Lesson';
    }

    public function submitAnswer(int $exerciseId): void
    {
        $answer = $this->selectedAnswers[$exerciseId] ?? null;

        if (! $answer) {
            Notification::make()
                ->title('Selecciona una respuesta')
                ->warning()
                ->send();

            return;
        }

        $exercise = Exercise::query()
            ->findOrFail($exerciseId);

        $expectedAnswer = $this->normalizeExpectedAnswer(
            $exercise->expected_answer
        );

        $isCorrect = $this->normalizeAnswer($answer) === $this->normalizeAnswer($expectedAnswer);

        $score = $isCorrect ? 100 : 0;

        $errorPattern = null;

        if (! $isCorrect) {
            $errorPattern = app(
                DetectErrorPatternService::class
            )->detect(
                $exercise,
                $answer
            );
        }

        if ($isCorrect) {
            $feedback = 'Correcto. Muy bien.';
        } else {
            $feedback = $exercise->explanation
                ?: 'La respuesta no es correcta.';

            if ($errorPattern) {
                $feedback .= ' Patrón detectado: '
                    . $errorPattern->name
                    . '.';
            }
        }

        UserAnswer::create([
            'user_id' => auth()->id(),
            'exercise_id' => $exercise->id,
            'answer' => $answer,
            'is_correct' => $isCorrect,
            'score' => $score,
            'response_time' => null,
            'feedback' => $feedback,
            'error_pattern_id' => $errorPattern?->id,
        ]);

        $progress = UserProgress::firstOrNew([
            'user_id' => auth()->id(),
            'lesson_id' => $exercise->lesson_id,
        ]);

        $progress->attempts = $progress->exists
            ? $progress->attempts + 1
            : 1;

        $progress->status = $isCorrect
            ? 'completed'
            : 'in_progress';

        $progress->score = max(
            (int) $progress->score,
            $score
        );

        $progress->completed_at = $isCorrect
            ? ($progress->completed_at ?? now())
            : $progress->completed_at;

        $progress->last_activity_at = now();

        $progress->save();

        $this->adaptiveRecommendation[$exerciseId] =
            $this->buildAdaptiveRecommendation($score);

        $this->feedback[$exerciseId] = [
            'is_correct' => $isCorrect,
            'message' => $feedback,
        ];

        Notification::make()
            ->title($isCorrect ? 'Respuesta correcta' : 'Respuesta incorrecta')
            ->body($feedback)
            ->{$isCorrect ? 'success' : 'danger'}()
            ->send();
    }

    protected function normalizeExpectedAnswer(mixed $expectedAnswer): string
    {
        if (is_array($expectedAnswer)) {
            return $expectedAnswer['answer']
                ?? $expectedAnswer['correct']
                ?? $expectedAnswer['value']
                ?? $expectedAnswer[0]
                ?? '';
        }

        return (string) $expectedAnswer;
    }

    protected function normalizeAnswer(string $answer): string
    {
        return mb_strtolower(trim($answer));
    }

    protected function buildAdaptiveRecommendation(int $score): array
    {
        if ($score >= 80) {
            return [
                'type' => 'next',
                'title' => 'Podés avanzar',
                'message' => 'Muy buen resultado. Estás listo para continuar con la siguiente lesson.',
            ];
        }

        if ($score < 50) {
            return [
                'type' => 'review',
                'title' => 'Conviene repasar',
                'message' => 'Detectamos que este punto necesita refuerzo. Te recomendamos revisar el contenido antes de avanzar.',
            ];
        }

        return [
            'type' => 'practice',
            'title' => 'Seguimos practicando',
            'message' => 'Vas bien, pero todavía conviene practicar un poco más este patrón.',
        ];
    }

    public function getViewData(): array
    {
        return [
            'lesson' => $this->lesson,
            'lessonProgress' => $this->lessonProgress,
            'nextLesson' => $this->nextLesson,
            'isLessonCompleted' => $this->isLessonCompleted,
        ];
    }

    public function getLessonProgressProperty(): ?UserProgress
    {
        return UserProgress::query()
            ->where('user_id', auth()->id())
            ->where('lesson_id', $this->lesson?->id)
            ->first();
    }

    public function getNextLessonProperty(): ?Lesson
    {
        if (! $this->lesson) {
            return null;
        }

        return Lesson::query()
            ->where('learning_module_id', $this->lesson->learning_module_id)
            ->where('order', '>', $this->lesson->order)
            ->orderBy('order')
            ->first();
    }

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    public function getIsLessonCompletedProperty(): bool
    {
        if (! $this->lesson) {
            return false;
        }

        $exerciseIds = $this->lesson->exercises->pluck('id');

        if ($exerciseIds->isEmpty()) {
            return false;
        }

        $correctAnswersCount = UserAnswer::query()
            ->where('user_id', auth()->id())
            ->whereIn('exercise_id', $exerciseIds)
            ->where('is_correct', true)
            ->distinct('exercise_id')
            ->count('exercise_id');

        return $correctAnswersCount === $exerciseIds->count();
    }
}
