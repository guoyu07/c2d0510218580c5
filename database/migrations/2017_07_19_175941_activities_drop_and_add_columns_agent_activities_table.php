<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivitiesDropAndAddColumnsAgentActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("INSERT INTO `trawish_common`.`images`(`type`, `image_path`, `connectable_id`, `connectable_type`, `created_at`, `updated_at`) SELECT 'path', `image_path`, `id`, 'App\\\Models\\\ActivityApp\\\AgentActivityModel', `created_at`, `updated_at` FROM `trawish_activities`.`agent_activities` WHERE `image_path` IS NOT NULL");

        Schema::connection('mysql6')->table('agent_activities', function (Blueprint $table) {
            $table->dropColumn('image_path');
            $table->string('duration', 25)->after('mode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql6')->table('agent_activities', function (Blueprint $table) {
            $table->dropColumn('duration');
            $table->text('image_path')->after('mode')->nullable();
        });
    }
}
