<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BackendViatorActivitiesTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('viator_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('backend_id')->unsigned()->nullable();
            $table->integer('sortOrder')->nullable();
            $table->string('supplierName')->nullable();
            $table->string('currencyCode')->nullable();
            $table->text('catIds')->nullable();
            $table->text('subCatIds')->nullable();
            $table->text('webURL')->nullable();
            $table->text('specialReservationDetails')->nullable();
            $table->integer('panoramaCount')->nullable();
            $table->integer('merchantCancellable')->nullable();
            $table->string('bookingEngineId')->nullable();
            $table->string('onRequestPeriod')->nullable();
            $table->integer('primaryGroupId')->nullable();
            $table->string('pas')->nullable();
            $table->text('shortDescription')->nullable();
            $table->string('title')->nullable();
            $table->double('price', 15)->default(0);
            $table->string('supplierCode')->nullable();
            $table->integer('translationLevel')->nullable();
            $table->string('primaryDestinationId')->nullable();
            $table->string('primaryDestinationName')->nullable();
            $table->text('thumbnailURL')->nullable();
            $table->string('priceFormatted')->nullable();
            $table->integer('rrp')->nullable();
            $table->string('rrpformatted')->nullable();
            $table->string('onSale')->nullable();
            $table->integer('videoCount')->nullable();
            $table->integer('rating')->nullable();
            $table->text('thumbnailHiResURL')->nullable();
            $table->integer('photoCount')->nullable();
            $table->integer('reviewCount')->nullable();
            $table->string('savingAmountFormated')->nullable();
            $table->string('specialOfferAvailable')->nullable();
            $table->string('shortTitle')->nullable();
            $table->text('uniqueShortDescription')->nullable();
            $table->integer('merchantNetPriceFrom')->nullable();
            $table->string('merchantNetPriceFromFormatted')->nullable();
            $table->integer('savingAmount')->nullable();
            $table->string('specialReservation')->nullable();
            $table->string('duration')->nullable();
            $table->string('code')->nullable();
            $table->integer('rank')->default(0);
            $table->string('status', 100)->nullable();
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
        Schema::connection('mysql2')->dropIfExists('viator_activities');
    }
}
