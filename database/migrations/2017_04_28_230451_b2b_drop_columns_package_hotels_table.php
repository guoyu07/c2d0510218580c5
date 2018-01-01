<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bDropColumnsPackageHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->dropColumn([
                    'route_id', 'tbtq_hotel_id', 'tbtq_temp_hotel_id',
                    'agoda_hotel_room_id', 'booking_hotel_room_id',
                    'skysacanner_hotel_id', 'skysacanner_temp_hotel_id',
                    'selected_hotel_vendor', 'status'
                ]);
            $table->string('hotel_code', 25)->after('id')->nullable();
            $table->string('vendor')->after('hotel_code')->nullable();
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
            $table->dropColumn(['hotel_code', 'vendor']);
            $table->integer('route_id')->after('id')->unsinged()->nullable();
            $table->integer('tbtq_hotel_id')
                        ->after('route_id')->unsinged()->nullable();
            $table->integer('tbtq_temp_hotel_id')
                        ->after('tbtq_hotel_id')->unsinged()->nullable();
            $table->integer('agoda_hotel_room_id')
                        ->after('tbtq_temp_hotel_id')->unsinged()->nullable();
            $table->integer('booking_hotel_room_id')
                        ->after('agoda_hotel_room_id')->unsinged()->nullable();
            $table->integer('skysacanner_hotel_id')
                        ->after('booking_hotel_room_id')->unsinged()->nullable();
            $table->integer('skysacanner_temp_hotel_id')
                        ->after('skysacanner_hotel_id')->unsinged()->nullable();
            $table->string('selected_hotel_vendor')
                        ->after('skysacanner_temp_hotel_id')->nullable();
            $table->string('status')
                        ->after('selected_hotel_vendor')->nullable();
        });
    }
}
