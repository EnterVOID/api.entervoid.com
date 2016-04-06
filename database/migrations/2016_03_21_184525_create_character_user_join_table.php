<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterUserJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('character_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->primary(['character_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_user');
    }
}
