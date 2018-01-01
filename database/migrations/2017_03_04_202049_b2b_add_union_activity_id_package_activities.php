<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddUnionActivityIdPackageActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_activities', function (Blueprint $table) {
            $table->integer('union_activity_id')->after('viator_temp_activity_id')->nullable();
            $table->integer('union_temp_activity_id')->after('union_activity_id')->nullable();
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
            $table->dropColumn([
                    "union_activity_id",
                    "union_temp_activity_id"
                ]);
        });
    }
}
