<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bSkysacannerHotelsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skyscanner_hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->text('request')->nullable();
            $table->longText('result')->nullable();
            $table->integer('selected_index')->nullable();
            $table->integer('temp_selected_index')->nullable();
            $table->integer('skysacanner_hotel_detail_id')->unsigned()->nullable();
            $table->integer('skysacanner_temp_hotel_detail_id')->unsigned()->nullable();
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
        Schema::dropIfExists('skysacanner_hotels');
    }
}
