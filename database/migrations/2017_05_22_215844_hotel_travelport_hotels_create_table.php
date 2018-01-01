<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelTravelportHotelsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql4')->create('travelport_hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code',25)->nullable();
            $table->string('chain',25)->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('city', 25)->nullable();
            $table->integer('star_rating')->default(0);
            $table->string('image', 2100)->nullable();
            $table->string('latitude', 25)->nullable();
            $table->string('longitude', 25)->nullable();
            $table->text('description')->nullable();
            $table->string('xml_path')->nullable();
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
        Schema::connection('mysql4')->dropIfExists('travelport_hotels');
    }
}
