<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiCruiseItinerariesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('cruise_itineraries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cruise_night_id')->unsigned();
            $table->integer('day_id')->unsigned();
            $table->string('port', 50);
            $table->time('eta');
            $table->time('etd');
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
        Schema::connection('mysql2')->dropIfExists('cruise_itineraries');
    }
}
