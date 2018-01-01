<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiAirportAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('airports', function (Blueprint $table) {
            $table->string('city')->after('airport_name');
            $table->string('country_code')->after('city');
            $table->string('world_area_code')->after('country_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('airports', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('country_code');
            $table->dropColumn('world_area_code');
        });
    }
}
