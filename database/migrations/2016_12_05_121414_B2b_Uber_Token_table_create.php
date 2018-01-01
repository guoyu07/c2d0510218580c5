<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class B2bUberTokenTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('uber_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('last_authenticated')->nullable();
            $table->string('expires_in')->nullable();
            $table->string('scope')->nullable();
            $table->string('token_type')->nullable();
            $table->datetime('refresh_before')->nullable();
            $table->string('refresh_token')->nullable();
            $table->text('access_token')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('uber_tokens');
    }
}
