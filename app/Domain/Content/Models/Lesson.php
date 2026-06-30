<?php

namespace App\Domain\Content\Models;

use App\Modules\Learning\Domain\Models\AdaptiveRecommendation;
use App\Modules\Learning\Domain\Models\UserProgress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    protected $fillable = [
        'learning_module_id',
        'title',
        'slug',
        'description',
        'order',
        'difficulty',
        'status',
        'estimated_minutes',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(
            LearningModule::class,
            'learning_module_id'
        );
    }

    public function contentBlocks(): HasMany
    {
        return $this->hasMany(ContentBlock::class, 'lesson_id')
            ->orderBy('order');
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class, 'lesson_id')
            ->orderBy('order');
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function adaptiveRecommendations(): HasMany
    {
        return $this->hasMany(
            AdaptiveRecommendation::class,
            'recommended_lesson_id'
        );
    }
}
