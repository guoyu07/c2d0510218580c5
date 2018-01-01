<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CruisesAddCruiseIdAndTypeColCruiseCabinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql5')->table('cruise_cabins', function (Blueprint $table) {
            $table->unsignedInteger('cruise_id')->after('id')->nullable();
            $table->string('cruise_type')->after('cruise_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql5')->table('cruise_cabins', function (Blueprint $table) {
            $table->dropColumn(['cruise_id', 'cruise_type']);
        });
    }
}
