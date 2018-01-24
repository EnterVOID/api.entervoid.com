<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type', 40);
            $table->unsignedInteger('user_id')->index();
            $table->longText('body');
            $table->nullableTimestamps();
			$table->unsignedInteger('updated_by')->nullable()->index();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
			$table->foreign('updated_by')
				->references('id')
				->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
