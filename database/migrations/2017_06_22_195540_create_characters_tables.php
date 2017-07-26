<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('character_statuses', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('legacy_id');
		});

		Schema::create('character_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('legacy_id');
		});

		Schema::create('characters', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->string('gender')->nullable();
			$table->string('height')->nullable();
			$table->string('weight')->nullable();
			$table->text('bio');
			$table->unsignedInteger('type_id')->index();
			$table->unsignedInteger('status_id')->index();
			$table->unsignedInteger('icon_id')->index()->nullable();
			$table->unsignedInteger('design_sheet_id')->index()->nullable();
			$table->unsignedInteger('intro_id')->nullable()->index();
			$table->string('intro_id_legacy')->nullable();
			$table->nullableTimestamps();
			$table->softDeletes();

			$table->foreign('type_id')
				->references('id')
				->on('character_types');

			$table->foreign('status_id')
				->references('id')
				->on('character_statuses');

			$table->foreign('icon_id')
				->references('id')
				->on('managed_files');

			$table->foreign('design_sheet_id')
				->references('id')
				->on('managed_files');

			$table->foreign('intro_id')
				->references('id')
				->on('matches');
		});

		Schema::create('character_supplementary_art', function (Blueprint $table) {
			$table->unsignedInteger('character_id')->index();
			$table->unsignedInteger('managed_file_id')->index();
			$table->nullableTimestamps();
			$table->softDeletes();
			$table->primary(['character_id', 'managed_file_id']);

			$table->foreign('character_id')
				->references('id')
				->on('characters');

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
		Schema::dropIfExists('character_supplementary_art');
		Schema::dropIfExists('characters');
		Schema::dropIfExists('character_statuses');
		Schema::dropIfExists('character_types');
    }
}
