<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminAddAndChangeColumnsAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->table('admins', function (Blueprint $table) {
            $table->unsignedInteger('image_profile_id')
                    ->after('payu_salt')->nullable();

            $table->unsignedInteger('image_logo_id')
                    ->after('image_profile_id')->nullable();

            $table->unsignedInteger('text_about_id')
                    ->after('image_logo_id')->nullable();

            $table->dropColumn('image_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql3')->table('admins', function (Blueprint $table) {
            $table->dropColumn([
                            'image_logo_id', 
                            'image_profile_id', 
                            'about_id'
                        ]);

            $table->string('image_path')->after('payu_salt')->nullable();
        });
    }
}
