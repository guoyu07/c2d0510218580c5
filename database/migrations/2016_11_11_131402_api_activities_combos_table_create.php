<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiActivitiesCombosTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('activities_combos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('prefix')->default('COMB');
            $table->string('countryCode')->nullable();
            $table->string('destinationCode')->nullable();
            $table->string('combo')->nullable();
            $table->string('status')->nullable();
            $table->string('statusBy')->nullable();
            
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
        Schema::dropIfExists('activities_combos');
    }
}
