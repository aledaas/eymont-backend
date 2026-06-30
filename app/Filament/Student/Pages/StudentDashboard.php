<?php

namespace App\Filament\Student\Pages;

use App\Domain\Content\Models\LearningModule;
use App\Modules\Assessment\Domain\Models\UserAnswer;
use App\Modules\Learning\Domain\Models\AdaptiveRecommendation;
use Filament\Pages\Page;

class StudentDashboard extends Page
{
    protected string $view = 'filament.student.pages.student-dashboard';

    protected static ?string $navigationLabel = 'Mi aprendizaje';

    protected static ?string $title = 'Mi aprendizaje';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 1;

    public function getViewData(): array
    {
        $user = auth()->user();

        $completedLessonIds = $user->progresses()
            ->where('status', 'completed')
            ->pluck('lesson_id');

        $availableModules = LearningModule::query()
            ->where('status', 'published')
            ->whereHas('lessons', function ($query) use ($completedLessonIds) {
                $query->whereNotIn('id', $completedLessonIds);
            })
            ->withCount([
                'lessons' => function ($query) use ($completedLessonIds) {
                    $query->whereNotIn('id', $completedLessonIds);
                },
            ])
            ->orderBy('sort_order')
            ->get();

        $answersByPattern = UserAnswer::query()
            ->where('user_id', $user->id)
            ->whereNotNull('error_pattern_id')
            ->with('errorPattern.recommendedLesson')
            ->get()
            ->groupBy('error_pattern_id');

        $frequentErrors = $answersByPattern
            ->map(function ($answers) {

                $errorPattern = $answers->first()->errorPattern;

                return [
                    'name' => $errorPattern?->name ?? 'Unknown error',
                    'count' => $answers->count(),
                ];
            })
            ->sortByDesc('count')
            ->values()
            ->toArray();

        $topErrorPattern = $answersByPattern
            ->sortByDesc(fn ($answers) => $answers->count())
            ->first()?->first()?->errorPattern;

        if (
            $topErrorPattern &&
            $topErrorPattern->recommendedLesson
        ) {
            AdaptiveRecommendation::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'error_pattern_id' => $topErrorPattern->id,
                    'recommended_lesson_id' => $topErrorPattern->recommendedLesson->id,
                    'status' => 'shown',
                ],
                [
                    'reason' => 'Frequent error pattern detected',
                    'shown_at' => now(),
                ]
            );
        }

        if ($topErrorPattern?->recommendedLesson) {
            AdaptiveRecommendation::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'error_pattern_id' => $topErrorPattern->id,
                    'recommended_lesson_id' => $topErrorPattern->recommendedLesson->id,
                    'status' => 'shown',
                ],
                [
                    'reason' => 'Top frequent error pattern recommendation.',
                    'shown_at' => now(),
                ]
            );
        }

        return [
            'user' => $user,

            'modulesCount' => $availableModules->count(),

            'availableModules' => $availableModules,

            'completedLessons' => $user->progresses()
                ->where('status', 'completed')
                ->count(),

            'masteredLessons' => $user->progresses()
                ->where('status', 'mastered')
                ->count(),

            'studyTime' => $user->learningSessions()
                ->sum('total_time'),

            'frequentErrors' => $frequentErrors,

            'topErrorPattern' => $topErrorPattern,
        ];
    }
}
