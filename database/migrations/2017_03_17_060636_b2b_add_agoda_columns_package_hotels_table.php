<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddAgodaColumnsPackageHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->integer('agoda_hotel_id')->after('tbtq_temp_hotel_id')
                    ->unsigned()->nullable();
            $table->integer('agoda_hotel_room_id')->after('agoda_hotel_id')
                    ->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->dropColumn([
                    'agoda_hotel_id',
                    'agoda_hotel_room_id'
                ]);
        });
    }
}
