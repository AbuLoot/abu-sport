<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->integer('country_id')->references('id')->on('countries');
            $table->integer('city_id')->references('id')->on('cities');
            $table->integer('district_id')->references('id')->on('districts');
            $table->integer('org_type_id')->references('id')->on('org_types');
            $table->string('slug');
            $table->string('title');
            $table->string('logo');
            $table->string('phones');
            $table->string('website');
            $table->string('emails');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('balance');
            $table->char('lang', 4);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('org_user', function (Blueprint $table) {
            $table->integer('org_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->primary(['org_id', 'user_id']);
        });

        Schema::create('org_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->string('slug');
            $table->string('title');
            $table->string('short_title');
            $table->char('lang', 4);
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
        Schema::drop('org_user');
        Schema::drop('org_types');
        Schema::drop('organizations');
    }
}
