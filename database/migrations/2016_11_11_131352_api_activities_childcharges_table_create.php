integer<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiActivitiesChildchargesTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('activities_childcharges', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('prefix')->default('CHCH');
            $table->string('activityId')->nullable();

            $table->integer('fromAge')->nullable();
            $table->integer('toAge')->nullable();
            
            $table->string('type')->nullable();

            $table->double('price')->nullable();
            
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
        Schema::dropIfExists('activities_childcharges');
    }
}
