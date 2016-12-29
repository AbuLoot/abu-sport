<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->integer('sport_id')->references('id')->on('sports');
            $table->integer('org_id')->references('id')->on('organizations');
            $table->integer('city_id')->references('id')->on('cities');
            $table->integer('district_id')->references('id')->on('districts');
            $table->string('slug');
            $table->string('title');
            $table->string('image');
            $table->string('images');
            $table->string('phones');
            $table->string('emails');
            $table->string('address');
            $table->text('description');
            $table->char('start_time', 10);
            $table->char('end_time', 10);
            $table->string('latitude');
            $table->string('longitude');
            $table->char('lang', 4);
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
        Schema::drop('areas');
    }
}
