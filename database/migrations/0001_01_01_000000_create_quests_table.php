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
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('directions_text');
			$table->text('intro_text');
            $table->integer('xp');
            $table->enum('status', ['active', 'archived']);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->integer('repeatable')->default(0);
			$table->text('accept_text')->nullable();
            $table->text('bonus_xp_text')->nullable();
            $table->text('complete_text')->nullable();
            $table->text('repeatability_text')->nullable();
			$table->integer('min_level');
            $table->date('start_date')->nullable();
            $table->date('expires_date')->nullable();


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
