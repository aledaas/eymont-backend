<?php

namespace App\Modules\Content\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentBlock extends Model
{
    use HasFactory;

    protected $table = 'content_blocks';

    protected $fillable = [
        'lesson_id',
        'type',
        'title',
        'content',
        'order',
        'difficulty',
        'neuro_tags',
        'metadata',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'metadata' => 'array',
            'neuro_tags' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(
            Lesson::class,
            'lesson_id'
        );
    }
}
