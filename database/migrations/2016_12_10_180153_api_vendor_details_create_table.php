<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiVendorDetailsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('vendor_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix')->default('IHC');
            $table->string('destination_code')->nullable();
            $table->string('preferred_currency')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('company_type')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_URL')->nullable();
            $table->string('star_rating')->nullable();
            $table->string('description')->nullable();
            $table->string('promotion')->nullable();
            $table->string('policy')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('special_instructions')->nullable();
            $table->string('trip_advisor_rating')->nullable();
            $table->string('trip_advisor_review_URL')->nullable();
            $table->string('smoking_preference')->nullable();
            $table->string('cancellation_allowed')->nullable();
            $table->string('status')->nullable();
            $table->string('statusby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('vendor_details');
    }
}
