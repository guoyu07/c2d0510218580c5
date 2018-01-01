<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageHotelsDropColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->dropColumn('extra_search');
            $table->dropColumn('global_hotel_result');
            $table->dropColumn('global_room_result');
            $table->dropColumn('tbtq_hotel_result');
            $table->dropColumn('tbtq_room_result');
            $table->dropColumn('fgf_hotel_result');
            $table->dropColumn('fgf_room_result');
            $table->dropColumn('temp_global_hotel_result');
            $table->dropColumn('temp_global_room_result');
            $table->dropColumn('temp_tbtq_hotel_result');
            $table->dropColumn('temp_tbtq_room_result');
            $table->dropColumn('temp_fgf_hotel_result');
            $table->dropColumn('temp_fgf_room_result');
            $table->dropColumn('selected_room');
            $table->dropColumn('api_action');
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
            $table->text('extra_search')->after('location')->nullable();
            $table->longText('global_hotel_result')->after('extra_search')->nullable();
            $table->longText('global_room_result')->after('global_hotel_result')->nullable();
            $table->longText('tbtq_hotel_result')->after('global_room_result')->nullable();
            $table->longText('tbtq_room_result')->after('tbtq_hotel_result')->nullable();
            $table->longText('fgf_hotel_result')->after('tbtq_room_result')->nullable();
            $table->longText('fgf_room_result')->after('fgf_hotel_result')->nullable();
            $table->longText('temp_global_hotel_result')->after('fgf_room_result')->nullable();
            $table->longText('temp_global_room_result')->after('temp_global_hotel_result')->nullable();
            $table->longText('temp_tbtq_hotel_result')->after('temp_global_room_result')->nullable();
            $table->longText('temp_tbtq_room_result')->after('temp_tbtq_hotel_result')->nullable();
            $table->longText('temp_fgf_hotel_result')->after('temp_tbtq_room_result')->nullable();
            $table->longText('temp_fgf_room_result')->after('temp_fgf_hotel_result')->nullable();
            $table->longText('selected_room')->after('temp_fgf_room_result')->nullable();
            $table->mediumText('api_action')->after('selected_room')->nullable();
        });
    }
}
