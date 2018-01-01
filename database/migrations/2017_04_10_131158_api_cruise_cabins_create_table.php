<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiCruiseCabinsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('cruise_cabins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_detail_id')->unsigned();
            $table->string('cabin_code', 50);
            $table->string('cabin');
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
        Schema::connection('mysql2')->dropIfExists('cruise_cabins');
    }
}
