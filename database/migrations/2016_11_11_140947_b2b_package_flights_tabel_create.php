<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageFlightsTabelCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_flights', function (Blueprint $table) {
            $table->increments('id');

            // this is for another table relation id so in the other table relation id will be : PKGHOTL1
            $table->string('prefix')->default('PKGFLGT'); 

            // this relation id will be client 'prefix'0000'id' like : FGF00001 or packages table id too
            $table->string('relation_id'); 
            
            // this will be fgf api destination id
            $table->string('request')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();

            $table->datetime('arrivalDateTime')->nullable(); 
            $table->datetime('departureDateTime')->nullable();


            /* No of Pax 
            |--------------------------------------------------------------------------
            | this data will be json_encode();
            | $Array =  [["NoOfAdult" => 2, "ChildAge" => [4,5]]];
            | $Child_Count = count($Array[ChildAge]);
            |--------------------------------------------------------------------------
            */
            $table->text('no_of_pax')->nullable(); 

            $table->text('extra_search')->nullable();

            /* Hotel Data
            |--------------------------------------------------------------------------
            | this data will be json_encode();
            | array will be same api hotel result responce
            |--------------------------------------------------------------------------
            */
            $table->longtext('global_flight_result')->nullable(); // this data will be in JSON
            $table->longtext('flights_result')->nullable(); // this data will be in JSON
            $table->longtext('temp_flight_result')->nullable(); // this data will be in JSON

            /* Hotel Data
            |--------------------------------------------------------------------------
            | it will never append previous data on update 
            | it will destroy previous data and update new one
            |
            | this data will be json_encode();
            | array will be same selected index like 
            | ['TBTQ'=>['room_result_index'=>['selected_room_index','selected_room_index2'...]]]
            |--------------------------------------------------------------------------
            */
            $table->text('selected_flights')->nullable();

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
        Schema::dropIfExists('package_flights');
    }
}
