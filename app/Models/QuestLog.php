<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestLog extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'quest_id',
		'status',
		'feedback',
		'feedback_type',
		'minutes',
		'accepted_at',
		'completed_at',
		'xp_awarded',
		'xp_bonus',
		'review',
		'reviewed_at',
		'reviewer_id',
		'reviewer_message',
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

	public static function getStatuses()
	{
		return [
			'Accepted',
			'Requested Exception',
			'Completed',
			'Dropped',
			'Expired'
		];
	}
}
