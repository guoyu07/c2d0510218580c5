<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminLeadVendorCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->create('lead_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned()->nullable();
            $table->string('company_name')->nullable();
            $table->string('contact_person')->nullable(); // dealing person name
            $table->string('contact_number')->nullable();
            $table->string('email_id')->nullable();
            $table->text('address')->nullable();
            $table->text('note')->nullable();
            $table->text('image_path')->nullable();
            $table->text('website')->nullable();
            $table->string('status')->nullable();
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
        Schema::connection('mysql3')->dropIfExists('lead_vendors');
    }
}
