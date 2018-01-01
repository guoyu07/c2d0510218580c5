<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FlightsAddColsAddedFlightSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql7')->table('added_flight_segments', function (Blueprint $table) {
            $table->boolean('is_default')->after('id')->default(0);
            $table->unsignedInteger('added_flight_id')
                        ->nullable()->change();
            $table->unsignedInteger('added_flight_segment_id')
                        ->after('is_default')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql7')->table('added_flight_segments', function (Blueprint $table) {
            $table->dropColumn(['is_default', 'added_flight_segment_id']);
        });
    }
}
