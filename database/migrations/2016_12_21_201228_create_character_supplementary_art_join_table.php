<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterSupplementaryArtJoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_supplementary_art', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('character_id')->index();
            $table->unsignedInteger('managed_file_id')->index();
            $table->primary(['character_id', 'managed_file_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_supplementary_art');
    }
}
