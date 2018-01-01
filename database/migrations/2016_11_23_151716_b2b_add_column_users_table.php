<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddColumnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('about')->nullable()->after('type');
            $table->text('address')->nullable()->after('about');
            $table->text('facebook')->nullable()->after('address');
            $table->text('googleplus')->nullable()->after('facebook');
            $table->text('linkedin')->nullable()->after('googleplus');
            $table->text('twitter')->nullable()->after('linkedin');
            $table->text('youtube')->nullable()->after('twitter');
            $table->text('instagram')->nullable()->after('youtube');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('about');
            $table->dropColumn('address');
            $table->dropColumn('facebook');
            $table->dropColumn('googleplus');
            $table->dropColumn('linkedin');
            $table->dropColumn('twitter');
            $table->dropColumn('youtube');
            $table->dropColumn('instagram');
        });
    }
}
