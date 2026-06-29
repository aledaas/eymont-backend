<?php

namespace App\Domain\Content\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorPattern extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'is_active',
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
}
