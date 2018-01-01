<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddMealColumnsRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->boolean('is_breakfast')->after('drop_off');
            $table->boolean('is_lunch')->after('is_breakfast');
            $table->boolean('is_dinner')->after('is_lunch');
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
            $table->dropColumns(['is_breakfast','is_lunch','is_dinner']);
        });
    }
}
