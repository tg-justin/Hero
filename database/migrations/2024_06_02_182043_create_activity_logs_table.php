<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quest_log_id');
            $table->unsignedBigInteger('hero_id');
            $table->dateTime('date');
            $table->unsignedBigInteger('actor_id');
            $table->text('change');
            $table->text('note');
            $table->dateTime('hero_viewed')->nullable();
            $table->dateTime('reviewed_date')->nullable();

            $table->timestamps();

            $table->foreign('quest_log_id')->references('id')->on('quest_logs')->onDelete('cascade');
            $table->foreign('hero_id')->references('id')->on('heroes')->onDelete('cascade');
            $table->foreign('actor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
