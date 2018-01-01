<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesAddColumnsAgentActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql6')->table('agent_activities', function (Blueprint $table) {
            $table->string('pick_up', 25)->after('timing')->nullable();
            $table->text('inclusion')->after('duration')->nullable();
            $table->text('exclusion')->after('inclusion')->nullable();
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
            $table->dropColumn(['pick_up', 'inclusion', 'exclusion']);
        });
    }
}
