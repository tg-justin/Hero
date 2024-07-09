<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quest extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'title',
		'intro_text',
		'accept_text',
		'directions_text',
		'complete_text',
		'min_level',
		'xp',
		'bonus_xp_text',
		'category_id',
		'campaign_id',
		'start_date',
		'expires_date',
		'notify_email',
		'file_paths',
		'status',
		'repeatable',
		'repeatability_text',
		'feedback_text',
		'feedback_type',

	];

	protected $casts = [
		'file_paths' => 'array', // Cast file_paths as an array
	];

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function campaign(): BelongsTo
	{
		return $this->belongsTo(Campaign::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function questLogs(): HasMany
	{
		return $this->hasMany(QuestLog::class);
	}

	public static function getFeedbackTypes(): array
	{
		return [
			'Hide',
			'Text',
			'Text Required',
			'HTML',
			'HTML Required',
		];
	}

	public function files(): HasMany
	{
		return $this->hasMany(File::class);
	}
}