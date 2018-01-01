<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

use DB;

class PackageCodeModel extends Model
{
	protected $table = 'package_codes';

	public function newCode()
	{
		$auth = auth()->user();
		$adminId = $auth->admin->id;
		$code = $this->where('admin_id', $adminId)->count();
		$code = $code+1;
		$this->admin_id = $adminId;
		$this->code = $code;
		$this->save();
		return $code;
	}
}
