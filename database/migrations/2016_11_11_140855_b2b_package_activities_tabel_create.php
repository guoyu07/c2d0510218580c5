<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageActivitiesTabelCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_activities', function (Blueprint $table) {
            $table->increments('id');
            
            // this is for another table relation id so in the other table relation id will be : PKGHOTL1
            $table->string('prefix')->default('PKGACTI'); 

            // this relation id will be client 'prefix'0000'id' like : FGF00001 or packages table id too
            $table->string('package_id'); 
            
            // this will be fgf api destination id
            $table->string('city_id');
            $table->date('start_date');
            $table->date('end_date');


            /* No of Pax 
            |--------------------------------------------------------------------------
            | this data will be json_encode();
            | $Array =  [["NoOfAdult" => 2, "ChildAge" => [4,5]]];
            | $Child_Count = count($Array[ChildAge]);
            |--------------------------------------------------------------------------
            */
            $table->text('location')->nullable();
            $table->text('pax')->nullable();
            $table->text('extra_search')->nullable();

            /* Hotel Data
            |--------------------------------------------------------------------------
            | this data will be json_encode();
            | array will be same api hotel result responce
            |--------------------------------------------------------------------------
            */
            $table->longtext('global_activities_result')->nullable(); // this data will be in JSON
            $table->longtext('final_activities_result')->nullable(); // this data will be in JSON
            $table->longtext('temp_activities_result')->nullable(); // this data will be in JSON

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
            $table->text('selected_activities')->nullable();

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
        Schema::dropIfExists('package_activities');
    }
}
