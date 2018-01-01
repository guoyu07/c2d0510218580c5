<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddColumnsInPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('prefix');
            $table->string('token', 100)->nullable();
            $table->integer('client_id')->unsigned()->change();
            $table->integer('package_code')
                    ->after('client_id')->unsigned()->nullable();
            $table->integer('modify_count')->after('package_code')->nullable();
            $table->boolean('is_locked')->after('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('prefix')->default('FGF');
            $table->dropColumn([
                    'package_code',
                    'modify_count',
                    'is_locked',
                ]);
        });
    }
}
