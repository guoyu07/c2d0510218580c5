<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CruisesCreateCttCruisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql5')->create('ctt_cruises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->string('month', 50)->nullable();
            $table->string('start_date', 50)->nullable();
            $table->string('url', 512)->nullable();
            $table->string('image', 512)->nullable();
            $table->string('image_alt', 512)->nullable();
            $table->string('image_title', 512)->nullable();
            $table->string('night_info', 255)->nullable();
            $table->string('cruise_url', 512)->nullable();
            $table->string('cruise_logo', 512)->nullable();
            $table->text('itinerary')->nullable();
            $table->string('prices', 2048)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('destination', 50)->nullable();
            $table->string('latitude', 25)->nullable();
            $table->string('longitude', 25)->nullable();
            $table->string('file_path', 512)->nullable();
            $table->string('cabins_json', 3072)->nullable();
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
        Schema::connection('mysql5')->dropIfExists('ctt_cruises');
    }
}
