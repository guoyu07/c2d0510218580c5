<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageHotelsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_hotels', function (Blueprint $table) {
            $table->integer('tbtq_hotel_id')->after('location')->unsigned()->nullable();
            $table->integer('tbtq_temp_hotel_id')->after('tbtq_hotel_id')->unsigned()->nullable();
            $table->string('selected_hotel_vendor')->after('tbtq_temp_hotel_id')->nullable();
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
            $table->dropColumn('tbtq_hotel_id');
            $table->dropColumn('tbtq_temp_hotel_id');
            $table->dropColumn('selected_hotel_vendor');
        });
    }
}
