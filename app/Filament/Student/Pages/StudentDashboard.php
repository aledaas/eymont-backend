<?php

namespace App\Filament\Student\Pages;

use App\Domain\Content\Models\LearningModule;
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

        $availableModules = LearningModule::query()
            ->where('status', 'published')
            ->withCount('lessons')
            ->orderBy('sort_order')
            ->get();

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
        ];
    }
}
