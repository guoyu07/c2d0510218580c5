<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddVisaCostColumnPackageCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_costs', function (Blueprint $table) {
            $table->decimal('visa_cost', 13, 2)->after('currency')->default(0);
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
            $table->dropColumn('visa_cost');
        });
    }
}
