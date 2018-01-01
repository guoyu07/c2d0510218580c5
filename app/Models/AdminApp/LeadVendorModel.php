<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\IndicationModel;
use App\Models\CommonApp\ImageModel;
use App\Models\B2bApp\ClientAliasModel;
use App\Models\B2bApp\ClientModel;
use App\Traits\CallTrait;

class LeadVendorModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql3';
	protected $table = 'lead_vendors';
	protected $appends = ['status', 'image'];
	protected $adminData;

	public function getImageAttribute()
	{
		return is_null($this->imageData) 
					 ? urlDefaultImageProfile()
					 : $this->imageData->url;
	}

	public function getStatusAttribute()
	{
		return is_null($this->indication) ? '' : $this->indication->name;
	}


	public function indication()
	{
		return $this->belongsTo(IndicationModel::class, 'is_active');
	}


	public function imageData()
	{
		return $this->belongsTo(ImageModel::class, 'image_id');
	}


	public function scopeUnlockOnly($query)
	{
		return $query->where('is_lock', '<>', 1);
	}


	public function scopeByAdmin($query)
	{
		$auth = $this->adminData();
		return $query->where('admin_id', $auth->id);
	}

	public function scopeSearch($query, $keyword = '')
	{
		return $query->where(function ($q) use ($keyword){
								$q->orWhere('email_id', 'like', '%'.$keyword.'%');
								$q->orWhere('company_name', 'like', '%'.$keyword.'%');
								$q->orWhere('contact_person', 'like', '%'.$keyword.'%');
								$q->orWhere('contact_number', 'like', '%'.$keyword.'%');
							});
		
	}


	public function lockData()
	{
		$auth = $this->adminData();
		$locked = null;

		if (!is_null($this->adminData())) {
			$locked = $this->where([
												'is_lock' => 1, 
												'admin_id' => $auth->id
											])
										->first();
		}

		return $locked;
	}


	public function defaultId()
	{
		$lockData = $this->lockData();
		return is_null($lockData) ? 1 : $lockData->id;
	}


	/*
	| run this function when going to create new admin
	*/
	public function createDefaultVendor($adminId)
	{
		$new = null;
		if (is_null($this->lockData())) {
			$new = new LeadVendorModel;
			$new->admin_id = $adminId;
			$new->company_name = 'Walk In';
			$new->is_lock = 1;
			$new->save();
		}
		return $new;
	}


	public function adminData()
	{
		return is_null($this->adminData)
				 ? auth()->guard('admin')->user()
				 : $this->adminData;
	}

	/*
	| this function is to update vendor id 
	| to the every where it used
	*/
	public function updateVendorId()
	{
		$data = ['lead_vendor_id' => $this->defaultId()];
		$where = ['lead_vendor_id' => $this->id];
		ClientModel::where($where)->update($data);
		ClientAliasModel::where($where)->update($data);
		return $this;
	}


}
