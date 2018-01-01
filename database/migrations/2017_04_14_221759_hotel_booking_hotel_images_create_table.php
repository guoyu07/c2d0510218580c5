<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelBookingHotelImagesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql4')->create('booking_hotel_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_hotel_id')->unsigned();
            $table->integer('bimgid')->nullable(); // booking image id which is in json
            $table->text('thumb_url')->nullable();
            $table->text('large_url')->nullable();
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
        Schema::connection('mysql4')->dropIfExists('booking_hotel_images');
    }
}
