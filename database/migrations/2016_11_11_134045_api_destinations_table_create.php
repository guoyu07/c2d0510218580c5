<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiDestinationsTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('destinations', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('country')->nullable();
            $table->string('fgf_countrycode')->nullable();
            $table->string('tbtq_countrycode')->nullable();
            $table->string('destination')->nullable();
            $table->string('fgf_destinationcode')->nullable();
            $table->string('tbtq_destinationcode')->nullable();
            $table->string('api')->nullable();
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
        Schema::dropIfExists('destinations');
    }
}
