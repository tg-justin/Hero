<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $fillable = [
		'title',
		'filename',
		'path',
		'quest_id',
		'quest_log_id',
	];

	public function quest()
	{
		return $this->belongsTo(Quest::class);
	}

	public function questLog()
	{
		return $this->belongsTo(QuestLog::class);
	}
}
