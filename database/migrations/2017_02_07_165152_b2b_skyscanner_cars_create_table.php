<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bSkyscannerCarsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skyscanner_cars', function (Blueprint $table) {
            $table->increments('id');
            $table->text('request')->nullable();
            $table->longText('result')->nullable();
            $table->integer('selected_index')->unsigned()->nullable();
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
        Schema::dropIfExists('skyscanner_cars');
    }
}
