<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageServiceModel extends Model
{
	protected $table = 'package_services';
	protected $appends = ['details', 'fusion_vendor', 'service_details'];
	protected $hidden = ['created_at', 'updated_at'];

	public function getDetailsAttribute()
	{
		return [
						"id" => $this->id,
						"ukey" => $this->fusion_id.'_'.$this->fusion_vendor,
						"type" => $this->type,
            "fusion_id" => $this->fusion_id,
            "fusion_vendor" => $this->fusion_vendor,
            "properties" => $this->packageServiceProperties->pluck('details')
					];
	}


	public function getFusionVendorAttribute()
	{
		$models = [
					'a' => 'App\Models\HotelApp\AgodaHotelModel',
					'b' => 'App\Models\HotelApp\BookingHotelModel',
					'tbo' => 'App\Models\HotelApp\TbtqJsonHotelModel',
					'qpx' => 'App\Models\FlightApp\QpxFlightModel',
					'ss' 	=> 'App\Models\FlightApp\SkyscannerFlightsModel',
					'own' => 'App\Models\FlightApp\AddedFlightModel',
				];
		return array_search($this->fusion_type, $models);
	}


	public function getServiceDetailsAttribute()
	{
		$accommodation = is_null($this->fusion) ? [] : $this->fusion->built_data;

		return collect([
				'accommodation' => collect([
						'details' => $accommodation,
						'properties' => $this->packageServiceProperties,
						'property_names' => $this->packageServiceProperties->pluck('property_name')
					])
			]);
	}


	public function scopeByFusionId($query, $fusionId)
	{
		return $query->where('fusion_id', $fusionId);
	}


	public function scopeByFusionType($query, $fusionType)
	{
		return $query->where('fusion_type', $fusionType);
	}


	public function fusion()
	{
		return $this->morphTo();
	}


	public function routes()
	{
		return $this->belongsToMany(
								'App\Models\B2bApp\RouteModel', 
								'package_service_route',
								'package_service_id',
								'route_id'
							)->withTimestamps();
	}


	public function packageServiceProperties()
	{
		return $this->hasMany(
								'App\Models\B2bApp\PackageServicePropertyModel', 
								'package_service_id'
							);
	}



}
