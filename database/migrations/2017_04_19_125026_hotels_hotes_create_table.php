<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelsHotesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql4')->create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor_type', 100);
            $table->integer('vendor_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            // $table->string('address')->nullable();
            $table->string('city')->nullable();
            // $table->string('country')->nullable();
            // $table->string('country_code')->nullable();
            // $table->string('image', 2100)->nullable();
            // $table->string('star_rating')->nullable();
            // $table->text('description')->nullable();
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
        Schema::connection('mysql4')->dropIfExists('hotels');
    }
}
