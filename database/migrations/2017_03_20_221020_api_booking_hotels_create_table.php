<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiBookingHotelsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::connection('mysql2')->create('booking_hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bid')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('city_hotel')->nullable();
            $table->string('cc1')->nullable();
            $table->string('ufi')->nullable();
            $table->string('class')->nullable();
            $table->string('currencycode')->nullable();
            $table->string('minrate')->nullable();
            $table->string('maxrate')->nullable();
            $table->string('preferred')->nullable();
            $table->string('nr_rooms')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('public_ranking')->nullable();
            $table->text('hotel_url')->nullable();
            $table->text('photo_url')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('desc_fr')->nullable();
            $table->text('desc_es')->nullable();
            $table->text('desc_de')->nullable();
            $table->text('desc_nl')->nullable();
            $table->text('desc_it')->nullable();
            $table->text('desc_pt')->nullable();
            $table->text('desc_ja')->nullable();
            $table->text('desc_zh')->nullable();
            $table->text('desc_pl')->nullable();
            $table->text('desc_ru')->nullable();
            $table->text('desc_sv')->nullable();
            $table->text('desc_ar')->nullable();
            $table->text('desc_el')->nullable();
            $table->text('desc_no')->nullable();
            $table->string('city_unique')->nullable();
            $table->string('city_preferred')->nullable();
            $table->integer('continent_id')->nullable();
            $table->integer('review_score')->nullable();
            $table->integer('review_nr')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('booking_hotels');
    }
}
