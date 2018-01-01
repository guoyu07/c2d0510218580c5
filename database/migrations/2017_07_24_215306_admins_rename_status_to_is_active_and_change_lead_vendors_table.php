<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminsRenameStatusToIsActiveAndChangeLeadVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->table('lead_vendors', function (Blueprint $table) {
            $table->unsignedInteger('image_id')
                    ->after('email_id')->nullable();
            $table->boolean('is_active')->after('website')->default(1);
            
            $table->string('address', 2048)->change();
            $table->string('note', 2048)->change();
            $table->string('website', 2048)->change();

            $table->dropColumn(['image_path', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql3')->table('lead_vendors', function (Blueprint $table) {
            $table->string('status', 25)
                    ->after('website')->nullable();
            $table->text('image_path')->after('note')->nullable();

            $table->text('address', 2048)->change();
            $table->text('note', 2048)->change();
            $table->text('website', 2048)->change();

            $table->dropColumn('image_id', 'is_active');
        });
    }
}
