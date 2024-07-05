<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quest_logs', function(Blueprint $table)
		{
			$table->id();
			$table->unsignedBigInteger('user_id');

			$table->unsignedBigInteger('quest_id');
			$table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');

			$table->enum('status', ['Accepted', 'Requested Exception', 'Completed', 'Dropped', 'Expired']);

			$table->text('feedback')->nullable();
			$table->enum('feedback_type', ['Hide', 'Text', 'Text Required', 'HTML', 'HTML Required'])->nullable();
			$table->integer('minutes')->nullable();

			$table->timestamp('accepted_at')->nullable();
			$table->timestamp('completed_at')->nullable();

			$table->integer('xp_awarded')->nullable();
			$table->integer('xp_bonus')->nullable();

			$table->boolean('review')->default(FALSE);
			$table->timestamp('reviewed_at')->nullable();
			$table->unsignedBigInteger('reviewer_id')->nullable();
			$table->text('reviewer_message')->nullable();

			$table->boolean('rewards_claimed')->default(FALSE);

			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('reviewer_id')->references('id')->on('users')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('quest_logs');
	}
};
