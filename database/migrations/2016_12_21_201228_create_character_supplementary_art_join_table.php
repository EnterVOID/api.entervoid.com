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
            $table->unsignedInteger('character_id')->index();
            $table->unsignedInteger('managed_file_id')->index();
            $table->nullableTimestamps();
            $table->softDeletes();
            $table->primary(['character_id', 'managed_file_id']);

            $table->foreign('character_id')
                ->references('id')
                ->on('characters');

            $table->foreign('managed_file_id')
                ->references('id')
                ->on('managed_files');
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
