<?php

namespace App\Modules\Content\Domain\Models;

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
}
