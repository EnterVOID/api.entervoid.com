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
			$table->unsignedInteger('comic_id')->index();
			$table->unsignedInteger('character_id')->index();
			$table->primary(['comic_id', 'character_id']);

			$table->foreign('comic_id')
				->references('id')
				->on('comics');

			$table->foreign('character_id')
				->references('id')
				->on('characters');
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
