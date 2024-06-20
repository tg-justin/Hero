<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$seeder = new CreateDefaultRolesAndPermissionsSeeder();
		$seeder->run();

		$user = User::create([
			'name' => 'Admin',
			'email' => 'justin@tabletopgaymers.org',
			'password' => bcrypt('password'),
			'email_verified_at' => now(),
		]);

		$user->assignRole('admin');
		$user->assignRole('manager');
		$user->assignRole('hero');

		$this->call([
			CategorySeeder::class,
		]);

		$this->call([
			QuestSeeder::class,
		]);

		$this->call([
			BadgeSeeder::class,
		]);

		// User::factory(10)->create();  // Creates 10 users with random data

		// Quest::factory(10)->create();;
	}
}
