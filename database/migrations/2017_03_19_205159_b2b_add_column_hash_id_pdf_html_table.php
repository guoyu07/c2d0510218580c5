<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Controllers\B2bApp\PdfHtmlController;

class B2bAddColumnHashIdPdfHtmlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pdf_htmls', function (Blueprint $table) {
            $table->string('hash_id')->after('id')->nullable();
        });

        PdfHtmlController::call()->copyIdasHashPdfHtmls();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdf_htmls', function (Blueprint $table) {
            $table->dropColumn('hash_id');
        });
    }
}
