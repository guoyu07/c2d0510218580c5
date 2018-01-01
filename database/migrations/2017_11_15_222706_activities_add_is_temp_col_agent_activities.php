<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesAddIsTempColAgentActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql6')->table('agent_activities', function (Blueprint $table) {
            $table->boolean('is_temp')->after('is_active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql6')->table('agent_activities', function (Blueprint $table) {
            $table->dropColumn('is_temp');
        });
    }
}
