<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bDropRoomGuestsAndLocationPackageHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->dropColumn([
                    'user_id', 
                    'package_id', 
                    'city_id', 
                    'check_in_date', 
                    'check_out_date', 
                    'room_guests', 
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
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->integer('user_id')->after('prefix')->unsigned()->nullable();
            $table->integer('package_id')->after('user_id')->unsigned()->nullable();
            $table->integer('city_id')->after('route_id')->unsigned()->nullable();
            $table->date('check_in_date')->after('city_id')->nullable();
            $table->date('check_out_date')->after('check_in_date')->nullable();
            $table->text('room_guests')->after('check_out_date')->nullable();
            $table->text('location')->after('room_guests')->nullable();
        });
    }
}
