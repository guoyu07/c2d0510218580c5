<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bTbtqHotelsCrateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbtq_hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->text('request')->nullable();
            $table->longtext('result')->nullable();
            $table->integer('selected_index')->unsigned()->nullable();
            $table->integer('temp_selected_index')->unsigned()->nullable();
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
        Schema::dropIfExists('tbtq_hotels');
    }
}
