<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bTbtqHotelsAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbtq_hotels', function (Blueprint $table) {
            $table->integer('tbtq_hotel_room_id')
                    ->after('selected_index')->unsigned()->nullable();

            $table->integer('tbtq_hotel_detail_id')
                    ->after('tbtq_hotel_room_id')->unsigned()->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbtq_hotels', function (Blueprint $table) {
            //
        });
    }
}
