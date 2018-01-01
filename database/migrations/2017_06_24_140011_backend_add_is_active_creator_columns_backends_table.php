<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BackendAddIsActiveCreatorColumnsBackendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql1')->table('backends', function (Blueprint $table) {
            $table->boolean('is_active')->after('remember_token')->default(0);
            $table->unsignedInteger('creator')->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql1')->table('backends', function (Blueprint $table) {
            $table->dropColumns(['is_active', 'creator']);
        });
    }
}
