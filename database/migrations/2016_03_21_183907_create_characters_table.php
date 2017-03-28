<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->timestamps();
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
