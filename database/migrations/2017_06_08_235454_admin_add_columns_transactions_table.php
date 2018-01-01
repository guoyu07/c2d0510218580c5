<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminAddColumnsTransactionsTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::connection('mysql3')->table('transactions', function (Blueprint $table) {
            $table->unsignedInteger('conjoinly_id')->after('uid');
            $table->string('conjoinly_type')->after('conjoinly_id')
                    ->nullable();
            $table->dropColumn('amount');
            $table->decimal('balance', 15,7)->after('amount');
            $table->decimal('deposited', 15,7)->after('balance')
                    ->default(0);
            $table->decimal('withdrawn', 15,7)->after('deposited')
                    ->default(0);
            $table->boolean('is_success');

            $table->string('tran_type', 25)->after('amount')
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql3')->table('transactions', function (Blueprint $table) {
            $table->decimal('amount', 15,8)->after('withdrawn');
            $table->dropColumn([
                            'conjoinly_id','conjoinly_type',
                            'balance', 'deposited', 
                            'withdrawn', 'tran_type',
                        ]);
        });
    }
}
