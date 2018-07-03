<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComicsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('comics', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('match_id')->index();
			$table->unsignedInteger('side')->index();
			$table->string('title');
			$table->string('legacy_id')->nullable();
			$table->boolean('accepted');
			$table->unsignedTinyInteger('winner')->nullable();
			$table->unsignedTinyInteger('extended');
			$table->nullableTimestamps();
			$table->timestamp('completed_at')->nullable();
			$table->timestamp('published_at')->nullable();
			$table->softDeletes();

			$table->foreign('match_id')
				->references('id')
				->on('matches');
		});

		Schema::create('comic_pages', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('comic_id')->index();
			$table->unsignedSmallInteger('page_number');
			$table->string('filename');
			$table->unsignedInteger('managed_file_id')->index();
			$table->nullableTimestamps();
			$table->softDeletes();

			$table->foreign('comic_id')
				->references('id')
				->on('comics');

			$table->foreign('managed_file_id')
				->references('id')
				->on('managed_files');

			$table->unique(['comic_id', 'filename']);
		});

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
		Schema::dropIfExists('comic_pages');
		Schema::dropIfExists('comics');
    }
}
