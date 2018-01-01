<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddUserIdAndDropStatusbyColumnsRedirectUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redirect_urls', function (Blueprint $table) {
            $table->integer('user_id')->after('id')->unsigned()->nullable();
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
        Schema::table('redirect_urls', function (Blueprint $table) {
            $table->string('statusby')->after('status')->nullable();
            $table->dropColumn('user_id');
        });
    }
}
