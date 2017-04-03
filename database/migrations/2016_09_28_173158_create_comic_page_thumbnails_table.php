<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComicPageThumbnailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comic_page_thumbnails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('page_id')->index();
            $table->unsignedInteger('managed_file_id')->index();
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->foreign('page_id')
                ->references('id')
                ->on('comic_pages');

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
        Schema::dropIfExists('comic_page_thumbnails');
    }
}
