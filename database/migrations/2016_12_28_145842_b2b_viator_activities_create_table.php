<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bViatorActivitiesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viator_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('destination_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('currency_code', 5)->nullable();
            $table->longtext('activities_result')->nullable();
            $table->longtext('temp_activities_result')->nullable();
            $table->longtext('selected_activities')->nullable();
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
        Schema::dropIfExists('viator_activities');
    }
}
