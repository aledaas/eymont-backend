<?php

namespace App\Domain\Content\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function contentBlock()
    {
        return $this->belongsTo(ContentBlock::class);
    }

    public function template()
    {
        return $this->belongsTo(
            ExerciseTemplate::class,
            'exercise_template_id'
        );
    }

    public function neuroTags()
    {
        return $this->belongsToMany(NeuroTag::class);
    }

    public function errorPatterns()
    {
        return $this->belongsToMany(ErrorPattern::class);
    }
}
