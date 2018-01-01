<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bEanCruisesItineraryDetailsTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ean_cruise_itinerary_details', function (Blueprint $table) {
            $table->increments('id');
            $table->text('request')->nullable();
            $table->longText('result')->nullable();
            $table->integer('selected_index')->nullable();
            $table->integer('temp_selected_index')->nullable();
            $table->integer('ean_cruise_cabin_id')->unsigned()->nullable();
            $table->integer('ean_temp_cruise_cabin_id')->unsigned()->nullable();
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
        Schema::dropIfExists('ean_cruise_itinerary_details');
    }
}
