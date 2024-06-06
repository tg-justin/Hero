<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Quest;

class QuestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quest_id',
        'status', // accepted, requested_exception, completed
        'completion_details',
        'accepted_at',
        'completed_at',
        'xp_awarded',
        'xp_bonus',
        'rewards_claimed',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
