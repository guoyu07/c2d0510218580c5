<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bAddIsActiveColumnFollowUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('follow_ups', function (Blueprint $table) {
            $table->boolean('is_active')
                    ->after('status')->default(1);
            $table->datetime('attended_at')
                    ->after('is_active')->nullable();
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
        Schema::table('follow_ups', function (Blueprint $table) {
            $table->string('status')->after('is_active')
                    ->default('active');
            $table->dropColumn(['is_active', 'attended_at']);
        });
    }
}
