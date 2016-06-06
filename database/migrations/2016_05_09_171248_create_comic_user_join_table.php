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
            $table->engine = 'InnoDB';
            $table->integer('comic_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->primary(['comic_id', 'user_id']);
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
