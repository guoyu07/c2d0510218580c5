<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiAgodaHotelImagesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('agoda_hotel_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->unsigned()->nullable();
            $table->integer('aid')->unsigned()->nullable();
            $table->string('Title')->nullable();
            $table->text('Location')->nullable();
            $table->text('LocationWithWideSize')->nullable();
            $table->text('LocationWithSquareSize')->nullable();
            $table->text('LocationWithSquareSize2X')->nullable();
            $table->string('Group')->nullable();
            $table->boolean('IsRoomImage');
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
        Schema::connection('mysql2')->dropIfExists('agoda_hotel_images');
    }
}
