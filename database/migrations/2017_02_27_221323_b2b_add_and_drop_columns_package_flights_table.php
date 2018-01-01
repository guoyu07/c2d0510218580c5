<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddAndDropColumnsPackageFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_flights', function (Blueprint $table) {
            $table->dropColumn([
                    'user_id',
                    'package_id',
                    'request'
                ]);

            $table->integer('skyscanner_flight_id')
                    ->after('qpx_temp_flight_id')->unsigned()->nullable();
            $table->integer('skyscanner_temp_flight_id')
                    ->after('skyscanner_flight_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_flights', function (Blueprint $table) {
            $table->integer('user_id')->after('prefix')->unsigned()->nullable();
            $table->integer('package_id')->after('user_id')->unsigned()->nullable();
            $table->text('request')->after('route_id')->nullable();

            $table->dropColumn([
                    'skyscanner_flight_id',
                    'skyscanner_temp_flight_id'
                ]);
        });
    }
}
