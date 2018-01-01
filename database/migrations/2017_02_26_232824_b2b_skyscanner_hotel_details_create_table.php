<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bSkyscannerHotelDetailsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skyscanner_hotel_details', function (Blueprint $table) {
            $table->increments('id');
            $table->text('request')->nullable();
            $table->longText('result')->nullable();
            $table->integer('agent_prices_index')->nullable();
            $table->integer('room_offers_index')->nullable();
            $table->integer('room_index')->nullable();
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
        Schema::dropIfExists('skyscanner_hotel_details');
    }
}
