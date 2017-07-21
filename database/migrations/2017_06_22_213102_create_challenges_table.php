<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('challenges', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title')->nullable();
			$table->integer('length');
			$table->integer('page_limit')->nullable();
			$table->text('message')->nullable();
			$table->unsignedInteger('type_id')->index();
			$table->nullableTimestamps();

			$table->foreign('type_id')
				->references('id')
				->on('match_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('challenges');
	}
}
