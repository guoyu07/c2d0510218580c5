<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bTbtqHotelDetailsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbtq_hotel_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hotel_code')->nullable();
            $table->text('request')->nullable();
            $table->longtext('result')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('tbtq_hotel_details');
    }
}
