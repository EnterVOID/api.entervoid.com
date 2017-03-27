<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComicPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comic_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('comic_id')->index();
            $table->unsignedSmallInteger('page_number');
            $table->string('filename');
            $table->unsignedInteger('managed_file_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('comic')
                ->references('id')
                ->on('comics');

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
        Schema::dropIfExists('comic_pages');
    }
}
