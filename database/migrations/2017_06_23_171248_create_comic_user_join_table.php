<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComicUserJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comic_user', function (Blueprint $table) {
            $table->unsignedInteger('comic_id');
            $table->unsignedInteger('user_id');
            $table->primary(['comic_id', 'user_id']);

            $table->foreign('comic_id')
                ->references('id')
                ->on('comics');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comic_user');
    }
}
