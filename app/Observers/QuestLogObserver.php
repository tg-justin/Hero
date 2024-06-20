<?php

namespace App\Observers;

use App\Models\Badge;
use App\Models\QuestLog;

class QuestLogObserver
{
	public function updated(QuestLog $questLog)
	{
		if ($questLog->wasChanged('status') && $questLog->status === 'Completed')
		{
			$hero = $questLog->user;

			// Badge logic
			$level = $hero->calculateLevel(); // Assuming you have this method

			// Check if the hero has earned a badge
			// this needs to check more accurately and add checks for new badges
			$badge = Badge::where('level_requirement', $level)->first();

			if ($badge && !$hero->badges->contains($badge->id))
			{
				$hero->badges()->attach($badge->id);
			}
		}
	}
}
