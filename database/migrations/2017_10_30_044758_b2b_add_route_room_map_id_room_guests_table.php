<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\B2bApp\RoomGuestModel;

class B2bAddRouteRoomMapIdRoomGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_guests', function (Blueprint $table) {
            $table->unsignedInteger('route_room_map_id')
                    ->after('package_id');
        });

        // syncing data
        $groupPackage = RoomGuestModel::all()->groupBy('package_id'); 
        $keys = $groupPackage->keys();

        $query = 'INSERT INTO trawish_b2b.`route_room_maps` (`package_id`, `is_default`) VALUES ('.$keys->implode(', 1), (').', 1);';
    
        $updateGuest = '';

        foreach ($keys as $key => $value) {
            $updateGuest .= 'UPDATE trawish_b2b.`room_guests` SET trawish_b2b.`room_guests`.`route_room_map_id`='.($key+1).' WHERE trawish_b2b.`room_guests`.package_id = '.$value.';'; 
        }
        
        $updateRoute = 'UPDATE trawish_b2b.`routes` SET trawish_b2b.routes.`route_room_map_id`= (SELECT trawish_b2b.`room_guests`.`route_room_map_id` FROM trawish_b2b.`room_guests` WHERE trawish_b2b.room_guests.`package_id` = trawish_b2b.routes.`package_id` LIMIT 1);';
        
        \DB::unprepared($query);
        \DB::unprepared($updateGuest);
        \DB::unprepared($updateRoute);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_guests', function (Blueprint $table) {
            $table->dropColumn('route_room_map_id');
        });
    }
}
