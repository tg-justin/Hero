<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
		'status',
		'repeatable',
		'repeatability_text',
		'feedback_text',
		'feedback_type',

	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function campaign()
	{
		return $this->belongsTo(Campaign::class);
	}

	public function questLogs()
	{
		return $this->hasMany(QuestLog::class);
	}

	public static function getFeedbackTypes()
	{
		return [
			'Hide',
			'Text',
			'Text Required',
			'HTML',
			'HTML Required'
		];
	}
}
