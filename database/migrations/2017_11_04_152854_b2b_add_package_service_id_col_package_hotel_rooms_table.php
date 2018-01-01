<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddPackageServiceIdColPackageHotelRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_hotel_rooms', function (Blueprint $table) {
            $table->unsignedInteger('package_service_id')
                    ->after('package_hotel_id')
                        ->nullable();

            $table->integer('no_of_rooms')->after('package_service_id')
                        ->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_hotel_rooms', function (Blueprint $table) {
            $table->dropColumn('package_service_id');
        });
    }
}
