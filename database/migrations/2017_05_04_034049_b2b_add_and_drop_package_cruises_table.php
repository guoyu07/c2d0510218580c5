<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddAndDropPackageCruisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_cruises', function (Blueprint $table) {
            $table->dropColumn([
                            'route_id', 'cruise_cabin_id', 
                            'selected_cruise_vendor',
                            'status'
                        ]);
            $table->string('cruise_code', 25)->after('id')->nullable();
            $table->string('vendor')->after('cruise_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_cruises', function (Blueprint $table) {
            $table->dropColumn(['cruise_code', 'vendor']);
            $table->integer('route_id')->after('id')->unsinged()->nullable();
            $table->integer('cruise_cabin_id')
                        ->after('route_id')->unsinged()->nullable();
            $table->integer('selected_cruise_vendor')
                        ->after('cruise_cabin_id')->unsinged()->nullable();
            $table->integer('status')
                        ->after('selected_cruise_vendor')->unsinged()->nullable();
        });
    }
}
