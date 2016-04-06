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
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->text('bio');
            $table->string('type');
            $table->string('status');
            $table->string('icon_id');
            $table->string('design_sheet_id');
            $table->integer('intro_id')->unsigned()->nullable()->index();
            $table->string('intro_id_legacy')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('characters');
    }
}
