<?php

namespace App\Domain\Content\Models;

use App\Modules\Learning\Domain\Models\AdaptiveRecommendation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ErrorPattern extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'student_message',
        'teacher_hint',
        'recommended_lesson_id',
        'severity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
    public function recommendedLesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'recommended_lesson_id');
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(
            AdaptiveRecommendation::class
        );
    }
}
