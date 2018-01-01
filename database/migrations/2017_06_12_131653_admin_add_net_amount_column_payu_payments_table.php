<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminAddNetAmountColumnPayuPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->table('payu_payments', function (Blueprint $table) {
            $table->decimal('net_amount', 15, 7)->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql3')->table('payu_payments', function (Blueprint $table) {
            $table->dropColumn('net_amount');
        });
    }
}
