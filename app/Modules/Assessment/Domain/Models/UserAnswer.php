<?php

namespace App\Modules\Assessment\Domain\Models;

use App\Domain\Content\Models\ErrorPattern;
use App\Domain\Content\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'exercise_id',
        'answer',
        'is_correct',
        'score',
        'response_time',
        'feedback',
        'error_pattern_id',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function errorPattern(): BelongsTo
    {
        return $this->belongsTo(ErrorPattern::class);
    }
}
