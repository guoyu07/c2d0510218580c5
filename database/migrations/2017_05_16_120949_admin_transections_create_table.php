<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminTransectionsCreateTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('mysql3')->create('transactions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('uid', 25)->nullable();
			$table->integer('admin_id')->unsigned();
			$table->integer('plan_id')->unsigned();
			$table->decimal('amount', 15, 4)->nullable();
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
		Schema::connection('mysql3')->dropIfExists('transactions');
	}
}
