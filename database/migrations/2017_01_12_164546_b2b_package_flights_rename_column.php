<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageFlightsRenameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_flights', function (Blueprint $table) {
            $table->renameColumn('relation_id', 'package_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_flights', function (Blueprint $table) {
            $table->renameColumn('package_id', 'relation_id');
        });
    }
}
