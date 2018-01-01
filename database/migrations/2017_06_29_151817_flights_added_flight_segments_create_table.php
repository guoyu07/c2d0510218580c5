<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FlightsAddedFlightSegmentsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql7')->create('added_flight_segments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('added_flight_id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('number')->nullable();
            $table->string('origin_code')->nullable();
            $table->string('destination_code')->nullable();
            $table->datetime('departure_date_time');
            $table->datetime('arrival_date_time');
            $table->boolean('is_active')->default(1);
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
        Schema::connection('mysql7')->dropIfExists('added_flight_segments');
    }
}
