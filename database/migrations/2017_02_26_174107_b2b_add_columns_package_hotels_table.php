<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddColumnsPackageHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->integer('skysacanner_hotel_id')
                    ->after('tbtq_temp_hotel_id')
                     ->unsigned()->nullable();
            $table->integer('skysacanner_temp_hotel_id')
                    ->after('skysacanner_hotel_id')
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
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->dropColumn([
                    "skysacanner_hotel_id",
                    "skysacanner_temp_hotel_id"
                ]);
        });
    }
}
