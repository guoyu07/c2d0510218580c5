<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminPayuPaymentsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->create('payu_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payable_id')->default(0);
            $table->string('payable_type')->nullable();
            $table->string('txnid');
            $table->boolean('is_success');
            $table->text('data');
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
        Schema::connection('mysql3')->dropIfExists('payu_payments');
    }
}
