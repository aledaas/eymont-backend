<?php

namespace App\Modules\IAM\Domain\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'current_level',
        'target_level',
        'native_language',
        'learning_goals',
        'preferences',
    ];

    protected $casts = [
        'learning_goals' => 'array',
        'preferences' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
