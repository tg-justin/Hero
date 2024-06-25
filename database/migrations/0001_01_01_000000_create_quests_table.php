<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quests', function(Blueprint $table)
		{
			$table->id();
			$table->unsignedBigInteger('user_id');

			$table->string('title');
			$table->text('intro_text');
			$table->text('accept_text')->nullable();
			$table->text('directions_text');
			$table->text('complete_text')->nullable();

			$table->integer('min_level');
			$table->integer('xp');
			$table->text('bonus_xp_text')->nullable();

			$table->unsignedBigInteger('category_id')->nullable();
			$table->unsignedBigInteger('campaign_id')->nullable();

			$table->date('start_date')->nullable();
			$table->date('expires_date')->nullable();

			$table->boolean('notify_email')->default(FALSE);

			$table->enum('status', ['Active', 'Archived'])->default('Active');

			$table->integer('repeatable')->default(0);
			$table->text('repeatability_text')->nullable();

			$table->text('feedback_text')->nullable();
			$table->enum('feedback_type', ['Hide', 'Text', 'Text Required', 'HTML', 'HTML Required'])->nullable();

			$table->timestamps();

			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
			//$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('quests');
	}
}
