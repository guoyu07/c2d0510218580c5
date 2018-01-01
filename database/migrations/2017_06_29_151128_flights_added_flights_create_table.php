<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FlightsAddedFlightsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql7')->create('added_flights', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('route_id');
            $table->string('origin');
            $table->string('destination');
            $table->date('date');
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
        Schema::connection('mysql7')->dropIfExists('added_flights');
    }
}
