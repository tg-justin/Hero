<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $fillable = ['title', 'filename', 'path', 'quest_id'];

	public function quest()
	{
		return $this->belongsTo(Quest::class);
	}
}
