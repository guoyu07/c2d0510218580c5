<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddRouteIdColPackageHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->unsignedInteger('route_id')->after('id');
        });

        \DB::unprepared("UPDATE `trawish_b2b`.`package_hotels` SET `trawish_b2b`.`package_hotels`.`route_id`=(SELECT `trawish_b2b`.`routes`.`id` FROM `trawish_b2b`.`routes` WHERE `trawish_b2b`.`routes`.`fusion_id` = `trawish_b2b`.`package_hotels`.`id` LIMIT 1);"); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->dropColumn('route_id');
        });
    }
}
