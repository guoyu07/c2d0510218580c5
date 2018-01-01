<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminAddPayuCredsColumnsAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->table('admins', function (Blueprint $table) {
            $table->string('payu_key')->after('balance');
            $table->string('payu_salt')->after('payu_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql3')->table('admins', function (Blueprint $table) {
            $table->dropColumn(['payu_key', 'payu_salt']);
        });
    }
}
