<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bPackageCostsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_costs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_id')->unsigned()->nullable();
            $table->string('currency')->nullable();
            $table->decimal('net_cost', 13, 2)->default(0);
            $table->decimal('margin', 13, 2)->default(0);
            $table->boolean('is_current')->default(1);
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
        Schema::dropIfExists('package_costs');
    }
}
