<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class ChildAgeModel extends Model
{
	protected $table = 'children_age';
	protected $hidden = ['details', 'created_at', 'updated_at'];

	public function getDetailsAttribute()
	{
		return collect([
								'id' => $this->id, 
								'age' => $this->age, 
								'is_bed' => $this->is_bed
							]);
	}

	public function scopeNotInIds($query, Array $ids)
	{
		return $query->whereNotIn('id', $ids);
	}


	public function copyChildAge($rgid)
	{
		$newChildAge = $this->replicate();
		$newChildAge->room_guest_id = $rgid;
		$newChildAge->save();
		return $newChildAge;
	}
	


}
