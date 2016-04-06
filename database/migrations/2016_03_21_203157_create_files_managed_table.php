<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesManagedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_managed', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->string('mime');
            $table->string('original_filename');
            $table->integer('attacher_id')->unsigned()->nullable()->index();
            $table->string('attacher_type')->nullable();
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
        Schema::dropIfExists('files_managed');
    }
}
