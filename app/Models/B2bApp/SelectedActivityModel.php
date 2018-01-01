<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

// ===========================Other model===========================
use App\Models\CommonApp\ActivityModel;
use App\Models\CommonApp\AgentActivityModel;
use App\Models\CommonApp\ViatorActivityModel;
use Carbon\Carbon;

class SelectedActivityModel extends Model
{
	protected $table = 'selected_activities';
	protected $appends = ['detail'];


	public function getDateAttribute($value)
	{
		return Carbon::parse($value);
	}


	public function getDetailAttribute()
	{
		$result = [];

		if ($this->vendor == 'f') {
			$result = ActivityModel::call()->findByCode($this->code);
		}
		elseif ($this->vendor == 'v') {
			$result = ViatorActivityModel::call()->findByCode($this->code);
		}
		elseif ($this->vendor == 'own') {
			$result = AgentActivityModel::call()->findByCode($this->code);
		}

		return $result;
	}


	public function scopeByPackageActivityId($query, $id)
	{
		return $query->where('package_activity_id', $id);
	}

}
