<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\HotelApp\HotelsController;


class VoucherServiceModel extends Model
{
	protected $table = 'voucher_services';
	protected $appends = [
					'uid', 'status', 'voucher_url', 
					'meals', 'accommodation_details',
					'built_data'
				];
	protected $casts = ['guests' => 'array', 'data' => 'array'];

	protected $dates = [
			'check_in',
			'check_out',
			'created_at',
			'updated_at',
		];

	public function getUidAttribute()
	{
		return auth()->user()->admin->prefix.'V'
						.str_pad($this->id, 7, '0', STR_PAD_LEFT);
	}

	public function getVoucherUrlAttribute()
	{
		return route('vouchers.showPDF', $this->token);
	}


	public function getTypeAttribute($value)
	{
		return proper($value);
	}


	public function getStatusAttribute()
	{
		return $this->is_active ? "Active" : "Inactive";
	}


	public function getAccommodationDetailsAttribute()
	{
		if (strtolower($this->type) == 'accommodation' && array_get($this->data, 'code', false) && array_get($this->data, 'vendor', false)) {
			return HotelsController::call()->hotelByCode($this->data)->first();
		}

		return [];
	}


	public function getBuiltDataAttribute()
	{
		return [		
			'vstoken' => $this->token,
			'type' => $this->type,
			'dest' => $this->destination->location,
			'dest_id' => $this->destination_id,
			'check_in' => $this->check_in->format('d/m/Y'),
			'check_out' => $this->check_out->format('d/m/Y'),
			'data' => $this->data,
			'guests' => $this->guests,
			'terms' => $this->terms,
			'remark' => $this->remark,
		];
	}


	public function scopeByToken($query, $token)
	{
		return $query->where('token', $token);
	}


	public function voucher()
	{
		return $this->belongsTo('App\Models\B2bApp\VoucherModel', 'voucher_id');
	}


	public function destination()
	{
		return $this->belongsTo('App\Models\CommonApp\DestinationModel', 'destination_id');
	}


	public function mealsString()
	{
		$meals = [];
		$string = '';
		$last = '';
		$name = array_get($this->data, 'prop_type', '');

		if (array_get($this->data, 'breakfast')) $meals[] = 'breakfast';
		if (array_get($this->data, 'lunch')) $meals[] = 'lunch';
		if (array_get($this->data, 'dinner')) $meals[] = 'dinner';
		
		$string = implode_as_word(', ', $meals, ' and ');

		if (strlen($string)){
			$string = $name.' with '.$string;
		}
		else{
			$string = $name.' - room only';
		}

		return $string.'.';
	}


	protected static function boot()
	{
		parent::boot();
		
		static::creating(function($model){
			$model->token = str_random(32); // setting token
		});
	}

}
