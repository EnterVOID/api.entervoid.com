<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('playlists', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('description')->nullable();
			$table->unsignedInteger('user_id')->index();
			$table->boolean('private');
			$table->smallInteger('order');
			$table->nullableTimestamps();
			$table->softDeletes();

			$table->foreign('user_id')
				->references('id')
				->on('users');
		});

		Schema::create('playlist_items', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('playlist_id')->index();
			$table->unsignedInteger('playlisted_id')->index();
			$table->string('playlisted_type', 40);
			$table->text('description')->nullable();
			$table->smallInteger('order');
			$table->nullableTimestamps();
			$table->softDeletes();

			$table->foreign('playlist_id')
				->references('id')
				->on('playlists');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::dropIfExists('playlist_items');
    	Schema::dropIfExists('playlists');
    }
}
