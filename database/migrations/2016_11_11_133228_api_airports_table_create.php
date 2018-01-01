<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiAirportsTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('airports', function (Blueprint $table) {
            $table->increments('id');

            $table->string('airport_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

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
        Schema::dropIfExists('airports');
    }
}
