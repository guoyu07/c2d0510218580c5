<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddTimeDurationTrackPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('track_packages', function (Blueprint $table) {
            $table->string('ip')->after('package_id')->nullable();
            $table->integer('time_duration')->after('ip')->default(5);
            $table->text('more_detail')->after('time_duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('track_packages', function (Blueprint $table) {
            $table->dropColumn(['ip', 'more_detail', 'time_duration']);
        });
    }
}
