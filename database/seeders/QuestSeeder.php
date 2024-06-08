<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quest;
use App\Models\Category;

class QuestSeeder extends Seeder
{
    public function run()
    {
        $quests = [
            [
                'user_id' => 1, // Assuming the admin user has an ID of 1
                'title' => 'Complete Your Hero Registration',
                'summary' => 'Tell us a bit about yourself and your interests!',
                'description' => '',
                'points' => 10,
                'category_id' => 1,
                'min_level' => 0,
                'repeatable' => 0,
                'expires_date' => null, // This quest doesn't expire
            ],
            [
                'user_id' => 1, // Assuming the admin user has an ID of 1
                'title' => 'Attend a Pride event wearing gaming gear',
                'summary' => 'Show your pride and your love for gaming!',
                'description' => '',
                'points' => 50,
                'category_id' => 2,
                'min_level' => 1,
                'repeatable' => 1,
                'expires_date' => '2024-06-30',
            ],
            [
                'user_id' => 1, // Assuming the admin user has an ID of 1
                'title' => 'Give TG a bump on social media',
                'summary' => 'Help spread the word about Tabletop Gaymers!',
                'description' => '',
                'points' => 10,
                'category_id' => 3,
                'min_level' => 1,
                'repeatable' => 1,
                'expires_date' => '2024-06-30',
            ],
            [
                'user_id' => 1, // Assuming the admin user has an ID of 1
                'title' => 'Host a Birthday Fundraiser on Facebook',
                'summary' => 'Raise funds for Tabletop Gaymers on your birthday!',
                'description' => '',
                'points' => 50,
                'category_id' => 5,
                'min_level' => 1,
                'repeatable' => 1,
                'expires_date' => '2024-12-31',
            ],
            [
                'user_id' => 1, // Assuming the admin user has an ID of 1
                'title' => 'Sign-Up to be a Gen Con GM',
                'summary' => 'Share your love of RPGs at Gen Con!',
                'description' => '',
                'points' => 100,
                'category_id' => 5,
                'min_level' => 1,
                'repeatable' => 0,
                'expires_date' => '2024-05-13', // Past expiration date, might want to adjust
            ],
            [
                'user_id' => 1, // Assuming the admin user has an ID of 1
                'title' => 'Create T-Shirt Design for the Donor Rewards Website',
                'summary' => 'Design a cool T-shirt for our donors!',
                'description' => '',
                'points' => 100,
                'category_id' => 3,
                'min_level' => 2,
                'repeatable' => 0,
                'expires_date' => '2024-07-31',
            ],
            [
                'user_id' => 1, // Assuming the admin user has an ID of 1
                'title' => 'Refer your local community center to the Gayme Night program',
                'summary' => 'Help create a safe space for LGBTQ+ gamers!',
                'description' => '',
                'points' => 200,
                'category_id' => 2,
                'min_level' => 2,
                'repeatable' => 0,
                'expires_date' => '2024-08-31',
            ],
            [
                'user_id' => 1, // Assuming the admin user has an ID of 1
                'title' => 'Refer your local game store to the Gaming Safe Space program',
                'summary' => 'Make gaming more inclusive!',
                'description' => '',
                'points' => 200,
                'category_id' => 2,
                'min_level' => 2,
                'repeatable' => 0,
                'expires_date' => '2024-08-31',
            ],
            [
                'user_id' => 1, // Assuming the admin user has an ID of 1
                'title' => 'Write a guide on starting a local gaymer group',
                'summary' => 'Share your expertise and empower others!',
                'description' => '',
                'points' => 300,
                'category_id' => 3,
                'min_level' => 2,
                'repeatable' => 0,
                'expires_date' => '2024-11-30',
            ],
        ];


        foreach ($quests as $questData) {
            Quest::create($questData);
        }
    }
}
