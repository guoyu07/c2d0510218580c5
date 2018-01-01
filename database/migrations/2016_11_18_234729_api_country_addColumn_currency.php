<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiCountryAddColumnCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('countries', function (Blueprint $table) {
            $table->string('currency')->nullable()->after('tbtq_countrycode');
            $table->string('currencyCode')->nullable()->after('currency');
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
            $table->dropColumn('currency');
            $table->dropColumn('currencyCode');
        });
    }
}
