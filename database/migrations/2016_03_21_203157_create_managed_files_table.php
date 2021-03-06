<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managed_files', function (Blueprint $table) {
			$table->increments('id');
            $table->string('path');
            $table->string('filename');
            $table->string('mime');
            $table->string('original_filename');
            $table->nullableTimestamps();
            $table->softDeletes();

			$table->unique(['path', 'filename']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managed_files');
    }
}
