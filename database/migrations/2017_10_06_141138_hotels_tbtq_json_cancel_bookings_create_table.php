<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelsTbtqJsonCancelBookingsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql4')->create('tbtq_json_cancel_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tbtq_json_room_book_id');
            $table->text('send_change_request')->nullable();
            $table->text('send_change_response')->nullable();
            $table->text('get_change_request')->nullable();
            $table->text('get_change_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql4')->dropIfExists('tbtq_json_cancel_bookings');
    }
}
