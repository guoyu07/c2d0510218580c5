<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Controllers\CommonApp\ChangeSomethingController;

class B2bDropTotalCostColumnPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ChangeSomethingController::call()->once();

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('total_cost');
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
            $table->text('total_cost')->after('end_date')->nullable();
        });
    }
}
