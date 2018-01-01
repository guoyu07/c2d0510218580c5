<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bChangeColumnsRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->date('start_date')->default('0000-00-00')
                    ->nullable(false)->change();
            $table->date('end_date')->default('0000-00-00')
                    ->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->datetime('start_date')
                    ->default('0000-00-00 00:00:00')
                        ->nullable(false)->change();
            $table->datetime('end_date')
                    ->default('0000-00-00 00:00:00')
                        ->nullable(false)->change();
        });
    }
}
