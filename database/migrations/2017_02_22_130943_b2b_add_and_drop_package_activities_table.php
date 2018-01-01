<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddAndDropPackageActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_activities', function (Blueprint $table) {
            $table->integer('route_id')->after('prefix')->unsigned()->nullable();

            $table->dropColumn([
                    'user_id', 
                    'package_id',
                    'package_hotel_id',
                    'city_id', 
                    'start_date', 
                    'end_date', 
                    'location'
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
            $table->dropColumn('route_id');
            
            $table->integer('user_id')->after('prefix')->unsigned()->nullable();
            $table->integer('package_id')->after('user_id')->unsigned()->nullable();
            $table->integer('package_hotel_id')->after('package_id')->unsigned()->nullable();
            $table->integer('city_id')->after('package_hotel_id')->unsigned()->nullable();
            $table->date('start_date')->after('city_id')->unsigned()->nullable();
            $table->date('end_date')->after('start_date')->unsigned()->nullable();
            $table->text('location')->after('end_date')->nullable();
        });
    }
}
