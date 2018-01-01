<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bDropAndAddColumnsPackageCruisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_cruises', function (Blueprint $table) {
            $table->dropColumn([
                    'prefix', 'user_id', 
                    'package_id', 'city_id', 
                    'check_in_date', 'nights',
                    'room_guests', 'location',
                    'extra_search', 'fgf_cruise_result',
                    'fgf_cabin_result', 'temp_fgf_cruise_result',
                    'temp_fgf_cabin_result', 'selected_cabin', 
                    'api_action'
                ]);

            $table->integer('fgf_cruise_id')->after('route_id')->unsigned()->nullable();

            $table->integer('fgf_temp_cruise_id')
                    ->after('fgf_cruise_id')->unsigned()->nullable();
            
            $table->integer('ean_cruise_id')
                    ->after('fgf_temp_cruise_id')->unsigned()->nullable();
            
            $table->integer('ean_temp_cruise_id')
                    ->after('ean_cruise_id')->unsigned()->nullable();
            
            $table->string('selected_cruise_vendor')
                    ->after('ean_temp_cruise_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_cruises', function (Blueprint $table) {
            $table->dropColumn([
                    'fgf_cruise_id','fgf_temp_cruise_id',
                    'ean_cruise_id','ean_temp_cruise_id',
                    'selected_cruise_vendor'
                ]);

            $table->string('prefix')->after('id')->default('PKGCRUS');
            $table->integer('user_id')->after('prefix')->unsigned()->nullable();
            $table->integer('package_id')->after('user_id')->unsigned()->nullable();
            $table->integer('city_id')->after('route_id')->unsigned()->nullable();
            $table->date('check_in_date')->after('city_id')->nullable();
            $table->integer('nights')->after('fgf_cruise_id')->nullable();
            $table->text('room_guests')->after('nights')->nullable();
            $table->text('location')->after('room_guests')->nullable();
            $table->text('extra_search')->after('location')->nullable();
            $table->longText('fgf_cruise_result')->after('extra_search')->nullable();
            $table->longText('fgf_cabin_result')->after('fgf_cruise_result')->nullable();
            $table->longText('temp_fgf_cruise_result')
                    ->after('fgf_cabin_result')->nullable();

            $table->longText('temp_fgf_cabin_result')
                    ->after('temp_fgf_cruise_result')->nullable();

            $table->text('selected_cabin')->after('temp_fgf_cabin_result')->nullable();
            $table->text('api_action')->after('selected_cabin')->nullable();
        });
    }
}
