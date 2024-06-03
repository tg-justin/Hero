<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\QuestLog;
use App\Models\Quest;
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
		'first_name',
		'last_name',
        'email',
		'pronouns',
		'level',
        'password',
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

    public function questLogs()
    {
        return $this->hasMany(QuestLog::class);
    }

    public function totalPoints()
    {
        return $this->questLogs()
            ->where('status', 'completed') // Only consider completed quests
            ->sum(
                \DB::raw('xp_awarded + COALESCE(xp_bonus, 0)') // Sum awarded XP and bonus XP (handle nulls)
            );
    }

    public function completedQuests()
    {
        return $this->questLogs()->where('status', 'completed')->with('quest');
    }

   public function xpPercentage()
	{
		$currentLevel = $this->calculateLevel();
		$xpThresholds = config('levels.thresholds'); 

		// Check if hero is at maximum level
		if ($currentLevel === count($xpThresholds) - 1) {
			return 100; // If at max level, show progress bar as full
		}
		// Get the XP needed to reach the current level
		$xpForCurrentLevel = $xpThresholds[$currentLevel]; 

		// Get the XP needed to reach the next level
		$xpForNextLevel = $xpThresholds[$currentLevel + 1]; 

		// Calculate XP within the current level
		$xpInCurrentLevel = $this->totalPoints() - $xpForCurrentLevel;

		// Calculate the total XP required to level up from the current level
		$totalXpForLevelUp = $xpForNextLevel - $xpForCurrentLevel; 

		// Calculate and return the percentage of XP within the current level
		return ($xpInCurrentLevel / $totalXpForLevelUp) * 100; 
	}
	
	public function calculateLevel()
	{
		$xpThresholds = config('levels.thresholds');

		// Find the highest level that the hero's XP meets or exceeds
		foreach ($xpThresholds as $level => $threshold) {
			if ($this->totalPoints() < $threshold) {
				return $level - 1; // Return the previous level
			}
		}

		return count($xpThresholds) - 1; // Maximum level (5 in this case) if XP exceeds the last threshold
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

		if ($newLevel > $this->level) {
			// Level Up!
			$this->level = $newLevel;

			// Check if this is the first login after leveling up (Optional)
			if ($this->last_login_at && $this->last_login_at < $this->updated_at) { 
				$this->last_notified_level = $newLevel;
			}

			$this->save(); // Save the updated level and last_notified_level

			// Perform any additional actions on level up (optional)
			//$this->awardLevelUpBonus(); // Example method to give rewards
			//$this->sendLevelUpNotification(); // Example method to send a notification
		}
	}
}
