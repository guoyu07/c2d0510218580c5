<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageHotelsTabelCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_hotels', function (Blueprint $table) {
            $table->increments('id');

            // this is for another table relation id so in the other table relation id will be : PKGHOTL1
            $table->string('prefix')->default('PKGHOTL'); 

            // this relation id will be client 'prefix'0000'id' like : FGF00001
            $table->string('relation_id'); 
            
            // this will be fgf api destination id
            $table->string('city_id');
            $table->date('check_in_date'); 
            $table->date('check_out_date');

            /* Room Guests 
            |--------------------------------------------------------------------------
            | this data will be json_encode();
            | $Array =  [["NoOfAdult" => 2, "ChildAge" => [4,5]]];
            | $Child_Count = count($Array[ChildAge]);
            |--------------------------------------------------------------------------
            */
            $table->text('room_guests'); 


            $table->text('location')->nullable();
            $table->text('extra_search')->nullable();

            /* Hotel Data
            |--------------------------------------------------------------------------
            | this data will be json_encode();
            | array will be same api hotel result responce
            |--------------------------------------------------------------------------
            */
            $table->longtext('global_hotel_result')->nullable(); // this data will be in JSON
            $table->longtext('global_room_result')->nullable(); // this data will be in JSON
            $table->longtext('tbtq_hotel_result')->nullable(); // this data will be in JSON
            $table->longtext('tbtq_room_result')->nullable();  // this data will be in JSON
            $table->longtext('fgf_hotel_result')->nullable();  // this data will be in JSON
            $table->longtext('fgf_room_result')->nullable();   // this data will be in JSON

            $table->longtext('temp_global_hotel_result')->nullable(); // this data will be in JSON
            $table->longtext('temp_global_room_result')->nullable(); // this data will be in JSON
            $table->longtext('temp_tbtq_hotel_result')->nullable(); // this data will be in JSON
            $table->longtext('temp_tbtq_room_result')->nullable();  // this data will be in JSON
            $table->longtext('temp_fgf_hotel_result')->nullable();  // this data will be in JSON
            $table->longtext('temp_fgf_room_result')->nullable();   // this data will be in JSON

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
            
            $table->longtext('selected_room')->nullable();
            $table->longtext('api_action')->nullable();

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
        Schema::dropIfExists('package_hotels');
    }
}
