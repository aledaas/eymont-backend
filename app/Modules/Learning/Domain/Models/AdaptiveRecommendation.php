<?php

namespace App\Modules\Learning\Domain\Models;

use App\Domain\Content\Models\ErrorPattern;
use App\Domain\Content\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdaptiveRecommendation extends Model
{
    protected $fillable = [
        'user_id',
        'error_pattern_id',
        'recommended_lesson_id',
        'reason',
        'status',
        'shown_at',
        'clicked_at',
    ];

    protected $casts = [
        'shown_at' => 'datetime',
        'clicked_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function errorPattern(): BelongsTo
    {
        return $this->belongsTo(ErrorPattern::class);
    }

    public function recommendedLesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'recommended_lesson_id');
    }
}
