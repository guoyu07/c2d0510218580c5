<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminsChangeStatusColumnTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->table('texts', function (Blueprint $table) {
            $table->boolean('is_active')->after('text')->default(1);
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql3')->table('texts', function (Blueprint $table) {
            $table->string('status', 25)->after('text')->nullable();
            $table->dropColumn('is_active');
        });
    }
}
