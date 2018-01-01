<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsStoredRoomAgodaHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('agoda_hotels', function (Blueprint $table) {
            $table->boolean('is_stored_room')->after('rates_currency')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('agoda_hotels', function (Blueprint $table) {
            $table->dropColumn('is_stored_room');
        });
    }
}
