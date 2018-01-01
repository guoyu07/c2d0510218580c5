<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddColumnsPackageActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_activities', function (Blueprint $table) {
            $table->integer('route_id')->after('id')->unsigned()->nullable();
            $table->string('mode', 25)->after('route_id')->nullable();
            $table->date('date')->after('mode')->nullable();
            $table->string('timing', 25)->after('date')->nullable();
            $table->integer('activity_id')->after('timing')->unsigned()->nullable();
            $table->string('activity_type')->after('activity_id')->nullable();
            $table->integer('is_active')->after('activity_type')->default(1);
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
                    'route_id', 'code', 'mode', 'date', 
                    'vendor', 'timing', 'is_active'
                ]);
        });
    }
}
