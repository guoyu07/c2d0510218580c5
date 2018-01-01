<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiAddColumnsActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('activities', function (Blueprint $table) {
            $table->integer('backend_id')->after('prefix')->unsigned()->nullable();
            $table->integer('rank')->after('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('activities', function (Blueprint $table) {
            $table->dropColumn(['backend_id', 'rank']);
        });
    }
}
