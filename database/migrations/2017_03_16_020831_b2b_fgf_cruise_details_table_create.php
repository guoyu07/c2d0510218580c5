<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bFgfCruiseDetailsTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fgf_cruise_details', function (Blueprint $table) {
            $table->increments('id');
            $table->text('request')->nullable();
            $table->longText('result')->nullable();
            $table->integer('selected_index')->nullable();
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
        Schema::dropIfExists('fgf_cruise_details');
    }
}
