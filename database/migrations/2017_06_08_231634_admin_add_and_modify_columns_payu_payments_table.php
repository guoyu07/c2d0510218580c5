<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminAddAndModifyColumnsPayuPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->table('payu_payments', function (Blueprint $table) {
            $table->boolean('is_success')->default(0)->change();
            $table->decimal('amount', 15,8)->after('txnid');
            $table->text('request')->after('is_success')->nullable();
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
            $table->dropColumn(['amount', 'request']);
        });
    }
}
