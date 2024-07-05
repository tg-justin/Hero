<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->id();
			$table->string('title');
			$table->string('filename');
			$table->string('path');
			$table->unsignedBigInteger('quest_id')->nullable();
			$table->unsignedBigInteger('quest_log_id')->nullable();
			$table->timestamps();

			$table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');
			$table->foreign('quest_log_id')->references('id')->on('quest_logs')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('files');
	}
};
