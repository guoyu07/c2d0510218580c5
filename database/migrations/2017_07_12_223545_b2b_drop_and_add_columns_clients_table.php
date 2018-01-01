<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bDropAndAddColumnsClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("UPDATE `clients` SET `status`= 0 WHERE `status` = 'deleted'");

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('prefix');
            $table->boolean('status')->default(1)->change();
            $table->string('token',100)->after('status')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("UPDATE `clients` SET `status` = 'deleted' WHERE `status`= 0;");
        Schema::table('clients', function (Blueprint $table) {
            $table->string('prefix', 7)->after('id')->default('CLNT');
            $table->string('status', 25)->after('status')
                                        ->default('active')
                                        ->change();
            $table->dropColumn(['token']);
        });
    }
}
