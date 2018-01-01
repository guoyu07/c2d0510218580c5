<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bViatorActivitiesDropAndRenameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('viator_activities', function (Blueprint $table) {
            $table->dropColumn('temp_activities_result');
            $table->renameColumn('activities_result', 'result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('viator_activities', function (Blueprint $table) {
            $table->longText('temp_activities_result');
            $table->renameColumn('result', 'activities_result');
        });
    }
}
