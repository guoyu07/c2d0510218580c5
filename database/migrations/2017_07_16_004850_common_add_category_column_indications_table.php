<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommonAddCategoryColumnIndicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('indications', function (Blueprint $table) {
            $table->string('category', 15)->after('id');
            $table->string('key', 15)->after('category');
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
            $table->dropColumn(['category', 'key']);
        });
    }
}
