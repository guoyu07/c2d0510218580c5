<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bTbtqHotelRoomsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbtq_hotel_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->text('request')->nullable();
            $table->longtext('result')->nullable();
            $table->integer('selected_index')->unsigned()->nullable();
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
        Schema::dropIfExists('tbtq_hotel_rooms');
    }
}
