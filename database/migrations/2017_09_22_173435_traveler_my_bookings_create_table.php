<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TravelerMyBookingsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql9')->create('my_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 50)->unique();
            $table->unsignedInteger('traveler_id');
            $table->unsignedInteger('booked_to_id');
            $table->string('booked_to_type');
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
        Schema::connection('mysql9')->dropIfExists('my_bookings');
    }
}
