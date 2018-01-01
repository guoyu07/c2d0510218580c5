<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageFlightsDropColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_flights', function (Blueprint $table) {
            $table->dropColumn('origin');
            $table->dropColumn('destination');
            $table->dropColumn('arrivalDateTime');
            $table->dropColumn('departureDateTime');
            $table->dropColumn('no_of_pax');
            $table->dropColumn('extra_search');
            $table->dropColumn('global_flight_result');
            $table->dropColumn('flights_result');
            $table->dropColumn('temp_flight_result');
            $table->dropColumn('selected_flights');
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
            $table->string('origin')->after('request')->nullable();
            $table->string('destination')->after('origin')->nullable();
            $table->datetime('arrivalDateTime')->after('destination')->nullable(); 
            $table->datetime('departureDateTime')->after('arrivalDateTime')->nullable();
            $table->text('no_of_pax')->after('departureDateTime')->nullable(); 
            $table->text('extra_search')->after('no_of_pax')->nullable();
            $table->text('global_flight_result')->after('selected_flight_vendor')->nullable();
            $table->text('flights_result')->after('global_flight_result')->nullable();
            $table->text('temp_flight_result')->after('flights_result')->nullable();
            $table->text('selected_flights')->after('temp_flight_result')->nullable();
        });
    }
}
