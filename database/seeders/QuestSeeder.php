<?php

namespace Database\Seeders;

use App\Models\Quest;
use Illuminate\Database\Seeder;

class QuestSeeder extends Seeder
{
	public function run()
	{
		$quests = [
			[
				'user_id' => 1, // Assuming the admin user has an ID of 1
				'title' => 'Complete Your Hero Registration',
				'intro_text' => 'Tell us a bit about yourself and your interests!',
				'directions_text' => '',
				'xp' => 10,
				'category_id' => 1,
				'min_level' => 0,
				'repeatable' => 0,
				'expires_date' => null, // This quest doesn't expire
			],
			[
				'user_id' => 1, // Assuming the admin user has an ID of 1
				'title' => 'Attend a Pride event wearing gaming gear',
				'intro_text' => 'Show your pride and your love for gaming!',
				'directions_text' => '',
				'xp' => 50,
				'category_id' => 2,
				'min_level' => 1,
				'repeatable' => 1,
				'expires_date' => '2024-06-30',
			],
			[
				'user_id' => 1, // Assuming the admin user has an ID of 1
				'title' => 'Give TG a bump on social media',
				'intro_text' => 'Help spread the word about Tabletop Gaymers!',
				'directions_text' => '',
				'xp' => 10,
				'category_id' => 3,
				'min_level' => 1,
				'repeatable' => 1,
				'expires_date' => '2024-06-30',
			],
			[
				'user_id' => 1, // Assuming the admin user has an ID of 1
				'title' => 'Host a Birthday Fundraiser on Facebook',
				'intro_text' => 'Raise funds for Tabletop Gaymers on your birthday!',
				'directions_text' => '',
				'xp' => 50,
				'category_id' => 5,
				'min_level' => 1,
				'repeatable' => 1,
				'expires_date' => '2024-12-31',
			],
			[
				'user_id' => 1, // Assuming the admin user has an ID of 1
				'title' => 'Sign-Up to be a Gen Con GM',
				'intro_text' => 'Share your love of RPGs at Gen Con!',
				'directions_text' => '',
				'xp' => 100,
				'category_id' => 5,
				'min_level' => 1,
				'repeatable' => 0,
				'expires_date' => '2024-05-13', // Past expiration date, might want to adjust
			],
			[
				'user_id' => 1, // Assuming the admin user has an ID of 1
				'title' => 'Create T-Shirt Design for the Donor Rewards Website',
				'intro_text' => 'Design a cool T-shirt for our donors!',
				'directions_text' => '',
				'xp' => 100,
				'category_id' => 3,
				'min_level' => 2,
				'repeatable' => 0,
				'expires_date' => '2024-07-31',
			],
			[
				'user_id' => 1, // Assuming the admin user has an ID of 1
				'title' => 'Refer your local community center to the Gayme Night program',
				'intro_text' => 'Help create a safe space for LGBTQ+ gamers!',
				'directions_text' => '',
				'xp' => 200,
				'category_id' => 2,
				'min_level' => 2,
				'repeatable' => 0,
				'expires_date' => '2024-08-31',
			],
			[
				'user_id' => 1, // Assuming the admin user has an ID of 1
				'title' => 'Refer your local game store to the Gaming Safe Space program',
				'intro_text' => 'Make gaming more inclusive!',
				'directions_text' => '',
				'xp' => 200,
				'category_id' => 2,
				'min_level' => 2,
				'repeatable' => 0,
				'expires_date' => '2024-08-31',
			],
			[
				'user_id' => 1, // Assuming the admin user has an ID of 1
				'title' => 'Write a guide on starting a local gaymer group',
				'intro_text' => 'Share your expertise and empower others!',
				'directions_text' => '',
				'xp' => 300,
				'category_id' => 3,
				'min_level' => 2,
				'repeatable' => 0,
				'expires_date' => '2024-11-30',
			],
		];

		foreach ($quests as $questData)
		{
			Quest::create($questData);
		}
	}
}
