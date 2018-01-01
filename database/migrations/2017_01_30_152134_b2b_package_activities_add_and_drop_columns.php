<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageActivitiesAddAndDropColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_activities', function (Blueprint $table) {
            $table->integer('package_hotel_id')->after('package_id')->unsigned()->nullable();
            $table->integer('fgf_activity_id')->after('location')->unsigned()->nullable();
            $table->integer('fgf_temp_activity_id')->after('fgf_activity_id')->unsigned()->nullable();
            $table->integer('viator_activity_id')->after('fgf_temp_activity_id')->unsigned()->nullable();
            $table->integer('viator_temp_activity_id')->after('viator_activity_id')->unsigned()->nullable();
            
            $table->dropColumn([
                    'pax',
                    'viator_activities_id', 
                    'extra_search', 
                    'global_activities_result', 
                    'final_activities_result', 
                    'temp_activities_result'
                ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_activities', function (Blueprint $table) {
            $table->dropColumn([
                    'package_hotel_id',
                    'fgf_activity_id', 
                    'fgf_temp_activity_id',
                    'viator_activity_id',
                    'viator_temp_activity_id'
                ]);

            $table->integer('viator_activity_id')->after('city_id')->unsigned()->nullable();
            $table->text('pax')->after('location')->nullable();
            $table->text('extra_search')->after('viator_activities_id')->nullable();
            $table->longText('global_activities_result')->after('extra_search')->nullable();
            $table->longText('final_activities_result')->after('global_activities_result')->nullable();
            $table->longText('temp_activities_result')->after('final_activities_result')->nullable();
        });
    }
}
