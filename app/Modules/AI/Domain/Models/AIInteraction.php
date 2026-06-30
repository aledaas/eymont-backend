<?php

namespace App\Modules\AI\Domain\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIInteraction extends Model
{
    protected $table = 'ai_interactions';

    protected $fillable = [
        'user_id',
        'provider',
        'model',
        'use_case',
        'input',
        'output',
        'status',
        'error_message',
        'tokens_input',
        'tokens_output',
        'latency_ms',
    ];

    protected $casts = [
        'input' => 'array',
        'output' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
