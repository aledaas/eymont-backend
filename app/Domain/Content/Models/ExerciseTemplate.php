<?php

namespace App\Domain\Content\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseTemplate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'schema',
        'is_active',
    ];

    protected $casts = [
        'schema' => 'array',
        'is_active' => 'boolean',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}
