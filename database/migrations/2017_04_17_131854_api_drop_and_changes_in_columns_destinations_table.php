<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiDropAndChangesInColumnsDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('destinations', function (Blueprint $table) {
            // Droped
            $table->dropColumn([
                    'tbtq_countycode', 'fgf_destinationcode',
                    'tbtq_destinationcode', 'status', 'statusby'
                ]);

            // Added
            $table->integer('backend_id')->after('id')->unsigned()->default(1);
            $table->boolean('is_active')->after('tags')->default(1);
            $table->string('latitude', 25)->nullable();
            $table->string('longitude', 25)->nullable();
            $table->text('geocode')->nullable();

            // Changed
            $table->string('country', 100)->nullable()->change();
            $table->string('destination', 100)->nullable()->change();
            $table->string('fgf_countrycode', 3)->nullable()->change();

            // Renamed
            $table->renameColumn('fgf_countrycode', 'country_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('destinations', function (Blueprint $table) {
            // Droped
            $table->dropColumn([    
                    'backend_id', 'is_active', 'latitude', 
                    'longitude', 'geocode'
                ]);

            // Added
            $table->string('tbtq_countycode', 100)->after('country_code')->nullable();
            $table->string('fgf_destinationcode', 100)
                    ->after('destination')->nullable();
            $table->string('tbtq_destinationcode', 100)
                    ->after('fgf_destinationcode')->nullable();
            $table->string('status', 25)->after('tags')->nullable();
            $table->string('statusby', 100)->after('status')->nullable();

            // Renamed
            $table->renameColumn('country_code', 'fgf_countrycode');

        });
    }
}
