<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterComicJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_comic', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('comic_id')->unsigned()->index();
            $table->integer('character_id')->unsigned()->index();
            $table->primary(['comic_id', 'character_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_comic');
    }
}
