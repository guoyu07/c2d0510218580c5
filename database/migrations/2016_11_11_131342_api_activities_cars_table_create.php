<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiActivitiesCarsTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('activities_cars', function (Blueprint $table) {
            $table->increments('id');

            $table->string('prefix')->default('ACAR');
            $table->string('activityId')->nullable();
            $table->string('carName')->nullable();

            $table->date('fromDate')->nullable();
            $table->date('toDate')->nullable();
            
            $table->string('capacity')->nullable();
            
            $table->double('price')->nullable();
            
            $table->text('description')->nullable();
            
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
        Schema::dropIfExists('activities_cars');
    }
}
