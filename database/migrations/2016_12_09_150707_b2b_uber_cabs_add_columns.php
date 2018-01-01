<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bUberCabsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uber_cabs', function (Blueprint $table) {
            $table->text('seat_count')->after('end_longitude')->nullable();
            $table->text('requests_estimate')->after('estimates')->nullable();
            $table->text('requests_current')->after('ride_request')->nullable();
            $table->text('book')->after('requests_current')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uber_cabs', function (Blueprint $table) {
            $table->dropColumn('requests_estimate');
            $table->dropColumn('requests_current');
            $table->dropColumn('book');
        });
    }
}
