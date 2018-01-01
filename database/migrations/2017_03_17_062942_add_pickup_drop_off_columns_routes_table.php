<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPickupDropOffColumnsRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->boolean('is_pick_up')->after('end_date')->default(0);
            $table->string('pick_up')->after('is_pick_up')->nullable();
            $table->boolean('is_drop_off')->after('pick_up')->default(0);
            $table->string('drop_off')->after('is_drop_off')->nullable();
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
            $table->dropColumn([
                    'is_pick_up','pick_up',
                    'is_drop_off','drop_off',
                ]);
        });
    }
}
