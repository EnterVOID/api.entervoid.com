<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHitlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('hitlist', function (Blueprint $table) {
			$table->unsignedInteger('user_id')->index();
			$table->unsignedInteger('character_id')->index();
			$table->smallInteger('order');
			$table->nullableTimestamps();
			$table->softDeletes();
			$table->primary(['user_id', 'character_id']);

			$table->foreign('user_id')
				->references('id')
				->on('users');

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
		Schema::dropIfExists('hitlist');
    }
}
