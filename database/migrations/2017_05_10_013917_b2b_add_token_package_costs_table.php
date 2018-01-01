<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddTokenPackageCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_costs', function (Blueprint $table) {
            $table->string('currency', 10)->change();
            $table->string('token', 40)->after('margin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_costs', function (Blueprint $table) {
            $table->string('currency')->change();
            $table->dropColumn('token');
        });
    }
}
