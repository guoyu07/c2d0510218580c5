<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageFlightsAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_flights', function (Blueprint $table) {
            $table->integer('qpx_flight_id')->after('route_id')->unsigned()->nullable();
            $table->integer('qpx_temp_flight_id')->after('qpx_flight_id')->unsigned()->nullable();
            $table->string('selected_flight_vendor')->after('qpx_temp_flight_id')->nullable();
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
            $table->dropColumn('qpx_flight_id');
            $table->dropColumn('is_flight_selected');
            $table->dropColumn('selected_flight_vendor');
        });
    }
}
