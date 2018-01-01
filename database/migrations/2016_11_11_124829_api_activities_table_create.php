<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiActivitiesTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('activities', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('prefix')->default('ACTV');
            $table->string('countryCode')->nullable();
            $table->string('destinationCode')->nullable();
            $table->string('currency')->nullable();
            $table->string('name')->nullable();
            
            $table->text('description')->nullable();
            
            $table->date('fromDate')->nullable();
            $table->date('toDate')->nullable();
            
            $table->tinyInteger('privateStatus')->nullable();
            $table->tinyInteger('priCabIncl')->nullable();
            
            $table->double('adultPrice', 15)->default(0);
            
            $table->tinyInteger('sicStatus')->default(0);
            
            $table->double('adultTktSic', 15)->nullable();
            
            $table->tinyInteger('cabStatus')->nullable();
            
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
        Schema::dropIfExists('activities');
    }
}

