<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\B2bApp\RouteModel;

class B2bAddTokenColumnRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->string('token', 50)->after('id');
        });
        
        $lastRec = RouteModel::orderBy('id', 'desc')->first();
        $query = [];
        if (!is_null($lastRec)) {
            for ($i=1; $i <= $lastRec->id; $i++) { 
                $query[] = "UPDATE `trawish_b2b`.`routes` SET `token`='".new_token()."' WHERE `id` = '".$i."';";
            }
        }
        $query = implode('', $query);
        \DB::unprepared($query);

        Schema::table('routes', function (Blueprint $table) {
            $table->string('token', 50)->unique()->change();
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
            $table->dropColumn('token');
        });
    }
}
