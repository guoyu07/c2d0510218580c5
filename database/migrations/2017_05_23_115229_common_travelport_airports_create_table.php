<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommonTravelportAirportsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('travelport_airports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10);
            $table->string('synonym', 5)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('state_code', 5)->nullable();
            $table->string('metro_code', 5)->nullable();
            $table->string('reference_city', 10)->nullable();
            $table->string('type', 3)->nullable();
            $table->string('host_service', 3)->nullable();
            $table->string('key', 10)->nullable();
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
        Schema::connection('mysql2')->dropIfExists('travelport_airports');
    }
}
