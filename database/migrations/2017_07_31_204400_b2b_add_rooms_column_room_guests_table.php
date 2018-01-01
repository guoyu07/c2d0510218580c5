<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddRoomsColumnRoomGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_guests', function (Blueprint $table) {
            $table->unsignedInteger('rooms')
                    ->after('package_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_guests', function (Blueprint $table) {
            $table->dropColumn('rooms');
        });
    }
}
