<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiViatorDestinationsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')
            ->create('viator_destinations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('sortOrder')->unsigned();
                $table->integer('selectable')->unsigned();
                $table->string('defaultCurrencyCode')->nullable();
                $table->string('lookupId')->nullable();
                $table->integer('parentId')->unsigned();
                $table->string('timeZone')->nullable();
                $table->string('iataCode')->nullable();
                $table->string('destinationName')->nullable();
                $table->string('destinationType')->nullable();
                $table->string('destinationId')->nullable();
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('viator_destinations');
    }
}
