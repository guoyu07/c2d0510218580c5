<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelsAddErrorColTbtqJsonHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql4')->table('tbtq_json_hotels', function (Blueprint $table) {
            $table->text('errors')->after('response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql4')->table('tbtq_json_hotels', function (Blueprint $table) {
            $table->dropColumn('errors');
        });
    }
}
