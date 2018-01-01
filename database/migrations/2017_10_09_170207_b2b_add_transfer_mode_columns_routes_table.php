<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddTransferModeColumnsRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->string('pick_up_mode', 20)->after('pick_up')->nullable();
            $table->string('drop_off_mode', 20)->after('drop_off')->nullable();

            // optimizing table col
            $table->string('mode', 25)->change();
            $table->string('origin_code', 20)->change();
            $table->string('destination_code', 20)->change();
            $table->string('pick_up', 50)->change();
            $table->string('drop_off', 50)->change();
            $table->string('status', 20)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn(['pick_up_mode','drop_off_mode']);
        });
    }
}
