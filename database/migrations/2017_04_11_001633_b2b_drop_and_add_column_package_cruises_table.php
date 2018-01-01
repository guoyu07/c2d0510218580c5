<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bDropAndAddColumnPackageCruisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_cruises', function (Blueprint $table) {
            $table->dropColumn([
                    'fgf_cruise_id', 'fgf_temp_cruise_id', 
                    'ean_cruise_id', 'ean_temp_cruise_id'
                ]);
            $table->integer('cruise_cabin_id')->after('route_id')
                    ->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_cruises', function (Blueprint $table) {
            $table->dropColumn('cruise_cabin_id');
            $table->integer('fgf_cruise_id')->after('route_id')
                    ->unsigned()->nullable();
            $table->integer('fgf_temp_cruise_id')->after('fgf_cruise_id')
                    ->unsigned()->nullable();
            $table->integer('ean_cruise_id')->after('fgf_temp_cruise_id')
                    ->unsigned()->nullable();
            $table->integer('ean_temp_cruise_id')->after('ean_cruise_id')
                    ->unsigned()->nullable();
        });
    }
}
