<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
	public function run()
	{
		$categories = [
			['name' => 'Getting Started', 'description' => 'Introduction to the Quest Board'],
			['name' => 'Main Story', 'description' => 'Quests that follow the main storyline'],
			['name' => 'Side Quests', 'description' => 'Optional quests that offer additional rewards'],
			['name' => 'Daily Challenges', 'description' => 'Quests that reset daily'],
			['name' => 'Community Events', 'description' => 'Special events with unique rewards'],

		];

		foreach ($categories as $categoryData)
		{
			Category::create($categoryData);
		}
	}
}
