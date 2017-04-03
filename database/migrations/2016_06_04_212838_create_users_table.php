<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('login');
            $table->integer('posts');
            $table->string('real_name')->nullable();
            $table->string('passwd');
            $table->string('email_address');
            $table->char('gender', 1)->nullable();
            $table->timestamp('birthdate')->nullable();
            $table->string('website_title')->nullable();
            $table->string('website_url')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('avatar_id')->index()->nullable();
            $table->string('avatar')->nullable();
            $table->integer('times_warned');
            $table->integer('extensions_available');
            $table->string('secret_question')->nullable();
            $table->string('secret_answer')->nullable();
            $table->string('password_salt');
            $table->nullableTimestamps();

            $table->foreign('avatar_id')
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
        Schema::dropIfExists('users');
    }
}
