<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('match_statuses', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('legacy_id');
		});

		Schema::create('match_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('legacy_id');
		});

		Schema::create('matches', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('slug');
			$table->unsignedInteger('type_id')->index();
			$table->integer('length');
			$table->integer('page_limit')->nullable();
			$table->timestamp('due_date')->nullable();
			$table->unsignedInteger('status_id')->index();
			$table->integer('view_count');
			$table->ipAddress('last_viewed_ip');
			$table->nullableTimestamps();
			$table->softDeletes();

			$table->foreign('type_id')
				->references('id')
				->on('match_types');

			$table->foreign('status_id')
				->references('id')
				->on('match_statuses');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('matches');
		Schema::dropIfExists('match_types');
		Schema::dropIfExists('match_statuses');
    }
}
