<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiCruisePricesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('cruise_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix')->default('CRUP');
            $table->integer('vendor_detail_id')->unsigned();
            $table->string('room_type')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('day_name')->nullable();
            $table->integer('nights')->unsigned()->nullable();
            $table->decimal('fare_adult', 20, 10)->unsigned();
            $table->decimal('fare_adult_promotional', 20, 10)->unsigned();
            $table->decimal('fare_extra_adult', 20, 10)->unsigned();
            $table->integer('default_pax')->unsigned()->nullable();
            $table->integer('min_pax')->unsigned()->nullable();
            $table->integer('max_pax')->unsigned()->nullable();
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
        Schema::connection('mysql2')->dropIfExists('cruise_prices');
    }
}
