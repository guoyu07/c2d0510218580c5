<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bCreateVoucherServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 32)->unique();
            $table->string('type', 20)->nullable();
            $table->integer('voucher_id')->unsigned()->nullable();
            $table->integer('destination_id')->unsigned()->nullable();
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->text('terms')->nullable();
            $table->text('remark')->nullable();
            $table->text('guests')->nullable();
            $table->text('data')->nullable();
            $table->integer('service_id')->unsigned()->nullable();
            $table->string('service_type')->nullable();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('voucher_services');
    }
}
