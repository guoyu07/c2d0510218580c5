<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelsCreateTboHotelRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql4')->create('tbo_hotel_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tbo_hotel_id')->nullable();
            $table->string('hotel_code', 50)->nullable();
            $table->string('roomtype')->nullable();
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
        Schema::connection('mysql4')->dropIfExists('tbo_hotel_rooms');
    }
}
