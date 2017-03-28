<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->integer('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->string('title');
            $table->string('size');
            $table->char('lang', 4);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->string('slug');
            $table->string('title');
            $table->char('lang', 4);
            $table->timestamps();
        });

        Schema::create('field_option', function (Blueprint $table) {
            $table->integer('field_id')->unsigned();
            $table->integer('option_id')->unsigned();

            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');

            $table->primary(['field_id', 'option_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('field_option');
        Schema::drop('fields');
        Schema::drop('options');
    }
}
