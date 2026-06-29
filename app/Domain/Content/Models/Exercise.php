<?php

namespace App\Domain\Content\Models;

use App\Modules\Assessment\Domain\Models\UserAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = [
        'lesson_id',
        'content_block_id',
        'exercise_template_id',
        'title',
        'type',
        'question',
        'options',
        'expected_answer',
        'explanation',
        'difficulty',
        'skill',
        'evaluation_criteria',
        'ai_evaluable',
        'status',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'expected_answer' => 'array',
        'evaluation_criteria' => 'array',
        'ai_evaluable' => 'boolean',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function contentBlock(): BelongsTo
    {
        return $this->belongsTo(ContentBlock::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(
            ExerciseTemplate::class,
            'exercise_template_id'
        );
    }

    public function neuroTags(): BelongsToMany
    {
        return $this->belongsToMany(NeuroTag::class);
    }

    public function errorPatterns(): BelongsToMany
    {
        return $this->belongsToMany(ErrorPattern::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }
}
