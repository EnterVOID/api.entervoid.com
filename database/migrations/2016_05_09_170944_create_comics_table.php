<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('match_id')->index();
            $table->string('title');
            $table->string('legacy_id')->nullable();
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();

            $table->foreign('match_id')
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
        Schema::dropIfExists('comics');
    }
}
