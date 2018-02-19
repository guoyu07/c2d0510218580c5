<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\B2bApp\ClientAliasModel;
use App\Models\B2bApp\PackageModel;
use App\Traits\CallTrait;

class ClientModel extends Model
{
	use CallTrait;

	protected $table = 'clients';
	protected $appends = ['uid', 'assign_to', 'built_data'];

	public function getUidAttribute()
	{
		return 'CID'.str_pad($this->id, 7, '0', STR_PAD_LEFT);
	}

	public function getTokenAttribute($token)
	{
		if (is_null($token) && strlen($token) < 5) {
			$token = new_token();
			$this->token = $token;
			$this->save();
		}
		return $token;
	}


	public function getAssignToAttribute()
	{
		return isset($this->user->assign_to) 
				 ? $this->user->assign_to
				 : '';
	}


	public function getBuiltDataAttribute()
	{
		return [
				'token' => $this->token,
				'name' => $this->fullname,
				'mobile' => $this->mobile,
				'email' => $this->email,
			];
	}


	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}


	public function packages(){
		return $this->hasMany('App\Models\B2bApp\PackageModel', 'client_id');
	}


	public function aliases()
	{
		return $this->hasMany(ClientAliasModel::class, 'client_id');
	}


	public function leadVendor(){
		return $this->belongsTo('App\Models\AdminApp\LeadVendorModel', 'lead_vendor_id');
	}



	public function scopeByAdmin($query, $guard = false)
	{
		$auth = $guard 
					? auth()->guard('admin')->user() 
					: auth()->user()->admin;

		return $query->whereHas('user', function($q) use ($auth) {
											$q->where(['admin_id' => $auth->id]);
										});
	}

	public function scopeByUser($query)
	{
		$auth = auth()->user();
		return $query->where(['user_id' => $auth->id]);
	}


	public function scopeByToken($query, $token)
	{
		return $query->where(['token' => $token]);
	}



	public function scopeMobileOrEmail($query, $mobile, $email)
	{
		return $query->where(function ($q) use ($mobile, $email){
											$q->where(["mobile" => $mobile])
												->orWhere(["email" => $email]);
										});
	}


	public function scopeByNotStatus($query, $status = 0)
	{
		return $query->where("status", "<>", $status);
	}


	public function scopeByStatus($query, $status)
	{
		return $query->where("status", "=", $status);
	}


	public function scopeByMobileSearch($query, $mobile)
	{
		return $query->where("mobile", "like", $mobile.'%');
	}


	public function scopeSearchName($query, $name)
	{
		return $query->where('fullname', 'like', '%'.$name.'%');
	}


	public function findByMobileEmail($mobile, $email)
	{
		return $this->mobileOrEmail($mobile, $email)
									->byUser()->byNotStatus()->first();
	}


	public function duplicateOrNew($mobile, $email)
	{
		$client = $this->findByMobileEmail($mobile, $email);

		if (!is_null($client)) {
			$alias = new ClientAliasModel;
			$alias->client_id = $client->id;
			$alias->user_id = $client->user_id;
			$alias->lead_vendor_id = $client->lead_vendor_id;
			$alias->fullname = $client->fullname;
			$alias->mobile = $client->mobile;
			$alias->email = $client->email;
			$alias->created_at = $client->updated_at;
			$alias->save();
		}
		else{
			$client = new ClientModel;
		}

		return $client;
	}


	public function openUrl()
	{
		return route('allPackage', $this->token);
	}


	public function createRouteUrl()
	{
		return route('createRoute', [$this->token]);
	}


	public function clientStatusData()
	{
		$auth = auth()->user();
		$userQuery = 'user_id = '.$auth->id;
		$query = "COUNT(*) as total, (SELECT COUNT(*) FROM `clients` WHERE status = 0 AND ".$userQuery.") as deleted, (SELECT COUNT(*) FROM `clients` WHERE status = 3 AND ".$userQuery.") as pending, (SELECT COUNT(*) FROM `clients` WHERE date(created_at) = '".date('Y-m-d')."' AND ".$userQuery.") as todays, (SELECT COUNT(*) FROM `follow_ups` WHERE date(datetime) = '".date('Y-m-d')."' AND ".$userQuery.") as follow_ups";

		return $this->select(\DB::raw($query))
									->where(['user_id' => $auth->id])
										->first();
	}



	public function vendorReport()
	{
		$query = "COUNT(*) AS times";
		return $this->select('lead_vendor_id', \DB::raw($query))
									->byUser()->groupBy('lead_vendor_id')->get();
	}


	public function vendorReportToArray()
	{
		$data = $this->vendorReport();
		$key = [];
		$value = [];
		foreach ($data as $client) {
			if (!is_null($client->leadVendor)) {
				$key[] = $client->leadVendor->company_name;
				$value[] = $client->times;  
			}
		}
		return (object)["key" => $key, 'value' => $value];
	}


	public function borderCss()
	{
		$css = '';
		if ($this->status== 0){
			$css = "red";
		}
		elseif($this->status==3){
			$css = "orange";
		}
		return $css;
	}


	public function statusCss()
	{
		return statusCss($this->status);
	}


	public function statusToWord()
	{
		return indication()->where('category', 'status')->get()
													->pluck('name')->pull($this->status);
	}

	
	public function findByAdminId($where = [])
	{
		$auth = auth()->guard('admin')->user();
		$where = array_merge(["admin_id" => $auth->id, ["status", "<>", "deleted"]], $where);

		$clients = DB::table('trawish_b2b.clients')
							->join('trawish_b2b.users', 'trawish_b2b.clients.user_id', '=', 'trawish_b2b.users.id')
							->join('trawish_admin.admins', 'trawish_b2b.users.id', '=', 'trawish_admin.admins.id')
							->select([
										'trawish_b2b.clients.*', 
										'trawish_b2b.users.admin_id', 
										'trawish_b2b.users.firstname AS user_firstname', 
										'trawish_b2b.users.lastname AS user_lastname', 
										'trawish_b2b.users.mobile As user_mobile', 
										'trawish_b2b.users.email As user_email', 
										'trawish_b2b.users.type As user_type', 
										'trawish_b2b.users.about As user_about', 
										'trawish_b2b.users.address As user_address', 
										'trawish_b2b.users.facebook As user_facebook', 
										'trawish_b2b.users.googleplus As user_googleplus', 
										'trawish_b2b.users.linkedin As user_linkedin', 
										'trawish_b2b.users.twitter As user_twitter', 
										'trawish_b2b.users.youtube As user_youtube', 
										'trawish_b2b.users.instagram As user_instagram', 
										'trawish_b2b.users.image_path As user_image_path'
									])
							->where($where)
							->skip(0)
							->take(20)
							->get();

		return $clients;

	}

}
