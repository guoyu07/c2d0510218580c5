<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiCruiseNightsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('cruise_nights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('backend_id')->unsigned();
            $table->integer('vendor_detail_id')->unsigned();
            $table->integer('nights')->unsigned();
            $table->string('title')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('cruise_nights');
    }
}
