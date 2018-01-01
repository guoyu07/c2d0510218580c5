<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\CommonApp\CountryModel;

class CommonAddIsActiveCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('countries', function (Blueprint $table) {
            $table->boolean('is_active')->after('currency_code')->default(1);
            $table->unsignedInteger('backend_id')->after('id');
            $table->dropColumn(['status', 'statusby']);        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('countries', function (Blueprint $table) {
            $table->string('status')->after('currency_code')->nullable();
            $table->string('statusby')->after('status')->nullable();
            $table->dropColumn(['is_active', 'backend_id']);
        });
    }
}
