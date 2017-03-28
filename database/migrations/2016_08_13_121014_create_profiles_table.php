<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('city_id')->references('id')->on('cities');
            $table->string('avatar');
            $table->string('phone');
            $table->date('birthday');
            $table->integer('growth')->nullable();
            $table->integer('weight')->nullable();
            $table->enum('sex', ['man', 'woman']);
            $table->text('about');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profiles');
    }
}
