<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('tournaments', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('description')->nullable();
			$table->nullableTimestamps();
			$table->softDeletes();
			$table->unique('name');
		});

		Schema::create('match_tournament', function (Blueprint $table) {
			$table->unsignedInteger('match_id')->index();
			$table->unsignedInteger('tournament_id')->index();
			$table->tinyInteger('round')->nullable();
			$table->softDeletes();
			$table->primary(['match_id', 'tournament_id']);

			$table->foreign('match_id')
				->references('id')
				->on('matches');

			$table->foreign('tournament_id')
				->references('id')
				->on('tournaments');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::dropIfExists('match_tournament');
    	Schema::dropIfExists('tournaments');
    }
}
