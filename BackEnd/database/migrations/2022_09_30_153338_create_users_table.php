<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 255)->unique();
            $table->string('name', 255);
            $table->string('password', 255);
            $table->rememberToken();
            $table->timeStamps();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_picture_cropped_1')->nullable();
            $table->string('profile_picture_original_1')->nullable();
            $table->string('profile_picture_cropped_2')->nullable();
            $table->string('profile_picture_original_2')->nullable();
            $table->string('profile_picture_cropped_3')->nullable();
            $table->string('profile_picture_original_3')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->tinyInteger('admin_flag')->nullable();
            $table->tinyInteger('delete_flag')->nullable();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
