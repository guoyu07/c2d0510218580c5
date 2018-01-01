<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;
use App\User;

class UserActivationModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql3';
	protected $table = 'user_activations';


	public function scopeByToken($query, $token)
	{
		return $query->where(['token' => $token]);
	}



	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}


	
	public function updateUsed($userId)
	{
		$this->call()
						->where(['user_id' => $userId, 'is_used' =>  0])
							->update(['is_used' => 1]);
	}



	public function activateUser($token)
	{
		$rsp = true;
		$user = $this->byToken($token)->first();
		if (is_null($user)) {
			exit('Sorry the link has been expired. <a href="'.url('/login').'">back</a>');
		}
		elseif (!$user->is_used) {
			if ($user->user->is_active != 1) {
				$user->user->is_active = 1;
				$user->user->save();
				$rsp = false;
			}
			$this->updateUsed($user->user_id);
		}

		$flash = $rsp 
					 ? 'You have already verified this account.'
					 : 'You have successfully verified this account.';

		session()->flash('success', $flash);

		return $rsp;
	}
}
