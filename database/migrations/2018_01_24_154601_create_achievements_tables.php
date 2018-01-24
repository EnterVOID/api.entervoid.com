<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('achievements', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedSmallInteger('points');
			$table->string('name');
			$table->unsignedInteger('image_id')->index()->nullable();
			$table->unsignedInteger('prerequisite')->index();
			$table->boolean('secret');
			$table->text('description')->nullable();
			$table->nullableTimestamps();
			$table->softDeletes();

			$table->foreign('image_id')
				->references('id')
				->on('managed_files');

			$table->foreign('prerequisite')
				->references('id')
				->on('achievements');

			$table->unique('name');
		});

		Schema::create('achievement_user', function (Blueprint $table) {
			$table->unsignedInteger('achievement_id')->index();
			$table->unsignedInteger('user_id')->index();
			$table->timestamp('achieved_at');
			$table->primary(['achievement_id', 'user_id']);

			$table->foreign('achievement_id')
				->references('id')
				->on('achievements');

			$table->foreign('user_id')
				->references('id')
				->on('users');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('achievement_user');
		Schema::dropIfExists('achievements');
    }
}
