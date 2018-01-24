<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('prizes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('image_id')->index()->nullable();
			$table->softDeletes();

			$table->foreign('image_id')
				->references('id')
				->on('managed_files');

			$table->unique('name');
		});

		Schema::create('character_prize', function (Blueprint $table) {
			$table->unsignedInteger('character_id')->index();
			$table->unsignedInteger('prize_id')->index();
			$table->timestamp('awarded_at')->nullable();
			$table->softDeletes();
			$table->primary(['character_id', 'prize_id']);

			$table->foreign('character_id')
				->references('id')
				->on('characters');

			$table->foreign('prize_id')
				->references('id')
				->on('prizes');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('character_prize');
		Schema::dropIfExists('prizes');
    }
}
