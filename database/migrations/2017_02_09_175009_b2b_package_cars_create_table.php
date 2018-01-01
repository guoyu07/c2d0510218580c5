<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageCarsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix')->default('PKGCARS');
            $table->integer('package_id')->unsigned();
            $table->text('request')->nullable();
            $table->integer('skyscanner_car_id')->unsigned()->nullable();
            $table->string('selected_car_vendor')->nullable();
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
        Schema::dropIfExists('package_cars');
    }
}
