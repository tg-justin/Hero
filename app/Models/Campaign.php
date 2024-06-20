<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
	use HasFactory;

	protected $fillable = [
		'title',
		'directions_text',
		'is_active',
	];

	public function quests()
	{
		return $this->hasMany(Quest::class);
	}
}
