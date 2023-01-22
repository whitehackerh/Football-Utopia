<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_detail', function (Blueprint $table) {
            $table->integer('user_id')->primary();
            $table->integer('looking_for_id')->nullable();
            $table->integer('league1_id')->nullable();
            $table->integer('league2_id')->nullable();
            $table->integer('league3_id')->nullable();
            $table->integer('clubteam1_id')->nullable();
            $table->integer('clubteam2_id')->nullable();
            $table->integer('clubteam3_id')->nullable();
            $table->integer('player1_id')->nullable();
            $table->integer('player2_id')->nullable();
            $table->integer('player3_id')->nullable();
            $table->integer('coach1_id')->nullable();
            $table->integer('coach2_id')->nullable();
            $table->integer('coach3_id')->nullable();
            $table->integer('position1_id')->nullable();
            $table->integer('position2_id')->nullable();
            $table->integer('position3_id')->nullable();
            $table->integer('favorite_part_id')->nullable();
            $table->integer('football_game_id')->nullable();
            $table->integer('playing_experience')->nullable();
            $table->text('about_me')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_detail');
    }
};
