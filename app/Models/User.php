<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\QuestLog;
use App\Models\Quest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
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
		'pronouns',
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
        // Replace this with your actual XP calculation logic
        $currentXp = $this->totalPoints(); // Assuming you have an 'xp' field in your User model
        $xpForNextLevel = 1000; // Example value, replace with your logic
        return ($currentXp / $xpForNextLevel) * 100;
    }
}
