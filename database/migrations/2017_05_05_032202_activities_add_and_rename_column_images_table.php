<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesAddAndRenameColumnImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('images', function (Blueprint $table) {
            $table->integer('connectable_id')->after('statusby')->unsigned()->nullable();
            $table->string('connectable_type')->after('connectable_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('images', function (Blueprint $table) {
            $table->dropColumn(['connectable_id', 'connectable_type']);
        });
    }
}
