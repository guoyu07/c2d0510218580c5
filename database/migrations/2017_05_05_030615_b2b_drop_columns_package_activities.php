<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bDropColumnsPackageActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_activities', function (Blueprint $table) {
            $table->dropColumn([
                    "route_id",
                    "fgf_activity_id",
                    "fgf_temp_activity_id",
                    "viator_activity_id",
                    "viator_temp_activity_id",
                    "union_activity_id",
                    "union_temp_activity_id",
                    "status"
                ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_activities', function (Blueprint $table) {
            $table->integer('route_id')->after('id')->unsigned()->nullable();
            $table->integer('fgf_activity_id')
                    ->after('route_id')->unsigned()->nullable();

            $table->integer('fgf_temp_activity_id')
                    ->after('fgf_activity_id')->unsigned()->nullable();

            $table->integer('viator_activity_id')
                    ->after('fgf_temp_activity_id')->unsigned()->nullable();

            $table->integer('viator_temp_activity_id')
                    ->after('viator_activity_id')->unsigned()->nullable();
            
            $table->integer('union_activity_id')
                    ->after('viator_temp_activity_id')->unsigned()->nullable();
            
            $table->integer('union_temp_activity_id')
                    ->after('union_activity_id')->unsigned()->nullable();
            
            $table->string('status')->after('union_temp_activity_id')->nullable();
        });
    }
}
