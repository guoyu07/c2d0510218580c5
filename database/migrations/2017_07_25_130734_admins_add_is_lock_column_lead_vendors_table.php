<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminsAddIsLockColumnLeadVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->table('lead_vendors', function (Blueprint $table) {
            $table->boolean('is_lock')->default(0)->after('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql3')->table('lead_vendors', function (Blueprint $table) {
            $table->dropColumn('is_lock');
        });
    }
}
