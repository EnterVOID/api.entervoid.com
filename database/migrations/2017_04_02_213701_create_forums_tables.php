<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 40);
            $table->unsignedTinyInteger('order');
            $table->nullableTimestamps();
        });
        Schema::create('forums', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->index();
            $table->unsignedInteger('parent_forum_id')->index();
            $table->string('name', 40);
            $table->text('description');
            $table->unsignedTinyInteger('order');
            $table->nullableTimestamps();

			$table->foreign('category_id')
				->references('id')
				->on('forum_categories');

			$table->foreign('parent_forum_id')
				->references('id')
				->on('forums');
        });
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forum_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('updated_by')->index();
            $table->boolean('sticky');
            $table->boolean('locked');
            $table->string('topic', 40);
            $table->mediumText('body');
            $table->unsignedTinyInteger('order');
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_topics');
        Schema::dropIfExists('forums');
        Schema::dropIfExists('forum_categories');
    }
}
