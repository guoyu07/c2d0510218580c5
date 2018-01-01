<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommonAddOrderColIndicationsTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('indications', function (Blueprint $table) {
            $table->unsignedInteger('order')->after('name')->nullable();
            $table->boolean('is_active')->after('order')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('indications', function (Blueprint $table) {
            $table->dropColumn(['order', 'is_active']);
        });
    }
}
