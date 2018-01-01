<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bDropPackageFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_flights', function (Blueprint $table) {
            $table->drop('package_flights');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_flights', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix', 10)->nullable();
            $table->unsignedInteger('route_id')->nullable();
            $table->integer('qpx_flight_id')->nullable();
            $table->integer('qpx_temp_flight_id')->nullable();
            $table->integer('skyscanner_flight_id')->nullable();
            $table->integer('skyscanner_temp_flight_id')->nullable();
            $table->string('selected_flight_vendor')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
}
