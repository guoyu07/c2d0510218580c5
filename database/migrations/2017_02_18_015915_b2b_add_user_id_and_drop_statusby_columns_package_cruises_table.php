<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddUserIdAndDropStatusbyColumnsPackageCruisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_cruises', function (Blueprint $table) {
            $table->integer('user_id')->after('prefix')->unsigned()->nullable();
            $table->dropColumn('statusby');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_cruises', function (Blueprint $table) {
            $table->string('statusby')->after('status')->nullable();
            $table->dropColumn('user_id');
        });
    }
}
