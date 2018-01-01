<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiCruiseDatesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('cruise_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix')->default('CRUD');
            $table->integer('vendor_detail_id')->unsigned();
            $table->string('itineraries')->nullable();
            $table->string('port_charges')->nullable();
            $table->date('date')->nullable();
            $table->string('season')->nullable();
            $table->string('nights')->nullable();
            $table->string('status')->nullable();
            $table->string('statusby')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('cruise_dates');
    }
}
