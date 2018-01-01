<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiActivitiesTimingsTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('activities_timings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('prefix')->default('ATIM');
            $table->string('activityId')->nullable();

            $table->time('openingTime')->nullable();
            $table->time('closingTime')->nullable();
            $table->time('duration')->nullable();

            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('activities_timings');
    }
}
