<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('campaigns');
	}

	public function up()
	{
		Schema::create('campaigns', function(Blueprint $table)
		{
			$table->id();
			$table->string('title');
			$table->text('directions_text')->nullable();
			$table->boolean('is_active')->default(true);
			$table->timestamps();
		});
	}
}
