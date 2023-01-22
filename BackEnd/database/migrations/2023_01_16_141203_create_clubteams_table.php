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
        Schema::create('clubteams', function (Blueprint $table) {
            $table->id();
            $table->integer('league_id');
            $table->integer('clubteam_id');
            $table->string('name', 255)->nullable();
            $table->timestamps();
            $table->unique(['league_id', 'clubteam_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubteams');
    }
};
