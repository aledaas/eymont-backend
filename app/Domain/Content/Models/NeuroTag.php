<?php

namespace App\Domain\Content\Models;

use Illuminate\Database\Eloquent\Model;

class NeuroTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
}
