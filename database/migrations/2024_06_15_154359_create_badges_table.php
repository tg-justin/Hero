<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('badges', function(Blueprint $table)
		{
			$table->id();
			$table->string('name');
			$table->string('slug'); // Unique identifier (e.g., 'level-1', 'level-5')
			$table->text('description');
			$table->string('image_path')->nullable(); // Store the badge image path
			$table->integer('level_requirement')->nullable(); // Level needed to earn the badge
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('badges');
	}
};
