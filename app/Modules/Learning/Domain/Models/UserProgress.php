<?php

namespace App\Modules\Learning\Domain\Models;

use App\Domain\Content\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'status',
        'score',
        'attempts',
        'completed_at',
        'last_activity_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
