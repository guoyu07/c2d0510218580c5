<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\B2bApp\RoomGuestModel;

class RouteRoomMapModel extends Model
{
	protected $table = 'route_room_maps';

	public function roomGuests()
	{
		return $this->hasMany(RoomGuestModel::class, 'route_room_map_id');
	}


	protected static function boot()
	{
		parent::boot();

		static::created(function($model){
			if ($model->is_default) {
				$guests = new RoomGuestModel;
				$guests->package_id = $model->package_id;
				$guests->route_room_map_id = $model->id;
				$guests->no_of_adult =  2;
				$guests->save();
			}
		});

		static::deleting(function ($model){
			$model->roomGuests()->delete();
		});
	}

}
