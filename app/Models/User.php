<?php

namespace App\Models;

use DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
	use HasFactory, Notifiable;
	use HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'first_name',
		'last_name',
		'pronouns',
		'location',
		'public_profile',
		'phone_number',
		'country',
		'address',
		'city',
		'state',
		'zip_code',
		'past_volunteer_experience',
		'level',
		'last_login_at',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	protected static function booted()
	{
		static::created(function($user)
		{
			$user->assignRole('hero'); // Assign the 'hero' role when a new user is created
		});
	}

	public function badges()
	{
		return $this->belongsToMany(Badge::class, 'hero_badge');
	}

	public function completedQuests()
	{
		return $this->questLogs()->where('status', 'Completed')->with('quest');
	}

	public function questLogs()
	{
		return $this->hasMany(QuestLog::class);
	}

	public function xpPercentage()
	{
		$currentLevel = $this->calculateLevel();
		$xpThresholds = config('levels.thresholds');

		// Check if hero is at maximum level
		if ($currentLevel === count($xpThresholds) - 1)
		{
			return 100; // If at max level, show progress bar as full
		}
		// Get the XP needed to reach the current level
		$xpForCurrentLevel = $xpThresholds[$currentLevel];

		// Get the XP needed to reach the next level
		$xpForNextLevel = $xpThresholds[$currentLevel + 1];

		// Calculate XP within the current level
		$xpInCurrentLevel = $this->totalxp() - $xpForCurrentLevel;

		// Calculate the total XP required to level up from the current level
		$totalXpForLevelUp = $xpForNextLevel - $xpForCurrentLevel;

		// Calculate and return the percentage of XP within the current level
		return ($xpInCurrentLevel / $totalXpForLevelUp) * 100;
	}

	public function calculateLevel()
	{
		$xpThresholds = config('levels.thresholds');

		// Find the highest level that the hero's XP meets or exceeds
		foreach ($xpThresholds as $level => $threshold)
		{
			if ($this->totalxp() < $threshold)
			{
				return $level - 1; // Return the previous level
			}
		}

		return count($xpThresholds) - 1; // Maximum level (5 in this case) if XP exceeds the last threshold
	}

	public function totalxp()
	{
		return $this->questLogs()
			->where('status', 'Completed') // Only consider completed quests
			->sum(
				DB::raw('xp_awarded + COALESCE(xp_bonus, 0)') // Sum awarded XP and bonus XP (handle nulls)
			);
	}

	public function getLevelNameAttribute()
	{
		$levelNames = config('levels.names'); // Retrieve names from config
		return $levelNames[$this->level] ?? 'Unknown';
	}

	public function needsLevelUpNotification()
	{
		return $this->level > $this->last_notified_level;
	}

	public function levelUp()
	{
		$newLevel = $this->calculateLevel();

		if ($newLevel > $this->level)
		{
			// Level Up!
			$this->level = $newLevel;

			// Check if this is the first login after leveling up (Optional)
			if ($this->last_login_at && $this->last_login_at < $this->updated_at)
			{
				$this->last_notified_level = $newLevel;
			}

			$this->save(); // Save the updated level and last_notified_level

			// log that this happened
			activity()
				->causedBy($this)
				->log('Leveled up to ' . $this->level);

			// Perform any additional actions on level up (optional)
			//$this->awardLevelUpBonus(); // Example method to give rewards
			//$this->sendLevelUpNotification(); // Example method to send a notification
		}
	}

	// auto assign hero role to user

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'email_verified_at' => 'datetime',
			'password' => 'hashed',
		];
	}
}
