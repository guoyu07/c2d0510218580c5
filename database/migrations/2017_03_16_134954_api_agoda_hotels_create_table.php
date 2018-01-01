<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiAgodaHotelsCreateTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('mysql2')->create('agoda_hotels', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('hotel_id')->unsigned()->nullable();
			$table->integer('chain_id')->nullable();
			$table->string('chain_name')->nullable();
			$table->integer('brand_id')->nullable();
			$table->string('brand_name')->nullable();
			$table->string('hotel_name')->nullable();
			$table->string('hotel_formerly_name')->nullable();
			$table->string('hotel_translated_name')->nullable();
			$table->text('addressline1')->nullable();
			$table->text('addressline2')->nullable();
			$table->string('zipcode')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('country')->nullable();
			$table->string('countryisocode', 20)->nullable();
			$table->float('star_rating')->nullable();
			$table->string('longitude', 30)->nullable();
			$table->string('latitude', 30)->nullable();
			$table->text('url')->nullable();
			$table->string('checkin')->nullable();
			$table->string('checkout')->nullable();
			$table->integer('numberrooms')->nullable();
			$table->integer('numberfloors')->nullable();
			$table->integer('yearopened')->nullable();
			$table->integer('yearrenovated')->nullable();
			$table->text('photo1')->nullable();
			$table->text('photo2')->nullable();
			$table->text('photo3')->nullable();
			$table->text('photo4')->nullable();
			$table->text('photo5')->nullable();
			$table->text('overview')->nullable();
			$table->integer('rates_from')->nullable();
			$table->integer('continent_id')->nullable();
			$table->string('continent_name')->nullable();
			$table->integer('city_id')->nullable();
			$table->integer('country_id')->nullable();
			$table->integer('number_of_reviews')->nullable();
			$table->float('rating_average')->nullable();
			$table->string('rates_currency', 10)->nullable();
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
		Schema::connection('mysql2')->dropIfExists('agoda_hotels');
	}
}
