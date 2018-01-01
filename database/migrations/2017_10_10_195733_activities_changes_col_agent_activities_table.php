<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesChangesColAgentActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql6')->table('agent_activities', function (Blueprint $table) {
            $table->string('destination_code', 25)->change();
            $table->string('title', 512)->change();
            $table->string('timing', 25)->change();
            $table->time('pick_up')->change();
            $table->string('mode', 25)->change();
            $table->time('duration')->change();
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
            //
        });
    }
}
