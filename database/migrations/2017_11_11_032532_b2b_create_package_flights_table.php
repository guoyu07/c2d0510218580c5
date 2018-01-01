<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Controllers\DatabaseManageController;

class B2bCreatePackageFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_flights', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('flight_id')->nullable();
            $table->string('flight_type')->nullable();
            $table->integer('index')->nullable();
            $table->timestamps();
        });

        // syncing all related table don't ever change this like or read first
        DatabaseManageController::call()->syncFlightWithPacakgeService();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_flights');
    }
}
