<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Controllers\DatabaseManageController;

class B2bCreatePackageServicePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_service_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('package_service_id');
            $table->string('type')->nullable();
            $table->unsignedInteger('no_of_rooms')->default(1);
            $table->unsignedInteger('property_id');
            $table->string('property_type')->nullable();
            $table->timestamps();
        });

        // syncing all related table don't ever change this like or read first
        DatabaseManageController::call()->syncPackageService();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_service_properties');
    }
}
