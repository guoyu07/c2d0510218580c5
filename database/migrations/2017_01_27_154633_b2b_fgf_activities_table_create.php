<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bFgfActivitiesTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fgf_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('city_id')->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->longtext('result')->nullable();
            $table->longText('select_index')->nullable();
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
        Schema::dropIfExists('fgf_activities');
    }
}
