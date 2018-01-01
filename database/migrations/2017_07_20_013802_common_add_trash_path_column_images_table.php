<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommonAddTrashPathColumnImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('images', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->string('image_path', 2048)->change();
            $table->string('trash_path', 2048)
                    ->after('image_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('images', function (Blueprint $table) {
            $table->dropColumn('trash_path');
            $table->text('image_path', 2048)->change();
            $table->text('url', 2048)->after('image_path')->change();
        });
    }
}
