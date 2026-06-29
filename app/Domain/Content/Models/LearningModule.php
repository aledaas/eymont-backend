<?php

namespace App\Domain\Content\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningModule extends Model
{
    use HasFactory;

    protected $table = 'learning_modules';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'level',
        'status',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'learning_module_id');
    }
}
