<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Controllers\DatabaseManageController;

class B2bAddColsPackageActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_activities', function (Blueprint $table) {
            $table->string('title')->after('duration')->nullable();
            $table->integer('description_id')->after('title')->nullable();
            $table->boolean('is_fullday')->after('duration')->default(0);
            $table->boolean('is_morning')->after('is_fullday')->default(0);
            $table->boolean('is_noon')->after('is_morning')->default(0);
            $table->boolean('is_evening')->after('is_noon')->default(0);
        });

        DatabaseManageController::call()->syncActivitesWithPacakgeService();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_activities', function (Blueprint $table) {
            $table->dropColumn(['title', 'description_id', 'is_fullday', 'is_morning', 'is_noon', 'is_evening']);
        });
    }
}
