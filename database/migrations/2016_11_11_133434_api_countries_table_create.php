<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiCountriesTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('countries', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('country')->nullable();
            $table->string('fgf_countrycode')->nullable();
            $table->string('tbtq_countrycode')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
