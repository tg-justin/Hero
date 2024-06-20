<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
	public function run()
	{
		// Level-Based Badges
		$levels = [1, 5, 10, 20, 50, 100];
		$titles = ['Initiate', 'Apprentice', 'Journeyman', 'Master', 'Grandmaster', 'Legend'];
		$descriptions = [
			'Embarked on the path of adventure.',
			'Demonstrated basic skills and knowledge.',
			'Mastered core techniques and strategies.',
			'Achieved a high level of expertise.',
			'Reached the pinnacle of skill and mastery.',
			'Became a legendary hero of renown.',
		];

		for ($i = 0; $i < count($levels); $i++)
		{
			Badge::create([
				'name' => 'Level ' . $levels[$i] . ' ' . $titles[$i],
				'slug' => 'level-' . $levels[$i],
				'description' => $descriptions[$i],
				'image_path' => 'images/badges/level-' . $levels[$i] . '.jpg',
				'level_requirement' => $levels[$i],
			]);
		}

		// Achievement-Based Badges
		$achievements = [
			[
				'name' => 'Quest Conqueror',
				'slug' => 'quest-conqueror',
				'description' => 'Completed 10 quests.',
				'level_requirement' => 1,
			],
			[
				'name' => 'Dragon Slayer',
				'slug' => 'dragon-slayer',
				'description' => 'Defeated a dragon in a quest.(Completed a quest worth more than 500 xp.)',
				'level_requirement' => null,
			],
			[
				'name' => 'Treasure Hunter',
				'slug' => 'treasure-hunter',
				'description' => 'Discovered 5 hidden treasures. (Claimed 5 rewards.)',
				'level_requirement' => null,
			],
			[
				'name' => 'Loremaster',
				'slug' => 'loremaster',
				'description' => 'Completed 5 guide writing quests.',
				'level_requirement' => null,
			],
			[
				'name' => 'Swift Strider',
				'slug' => 'swift-strider',
				'description' => 'Completed a quest in record time.(Months before the deadline.)',
				'level_requirement' => null,
			],
		];

		foreach ($achievements as $achievement)
		{
			Badge::create($achievement);
		}
	}
}
