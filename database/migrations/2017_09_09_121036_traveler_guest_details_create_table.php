<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TravelerGuestDetailsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql9')->create('guest_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tbtq_json_room_block_id');
            $table->integer('which_room');
            $table->string('title', 10)->nullable();
            $table->string('firstname', 40)->nullable();
            $table->string('lastname', 40)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('lead_passenger')->default(0);
            $table->integer('age')->nullable();
            $table->integer('passport_no')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();
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
        Schema::connection('mysql9')->dropIfExists('guest_details');
    }
}
