<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\UberTokenModel;
use App\Traits\CallTrait;

class UberTokenController extends Controller
{
	use CallTrait;

	public function fatchToken()
	{
		return UberTokenModel::select()->orderBy('id', 'desc')->first();
	}

	public function storeToken($request)
	{
		
		$token = new UberTokenModel;
		$token->scope = $request->scope;	
		$token->token_type = $request->token_type;	
		$token->expires_in = $request->expires_in;	
		$token->access_token = $request->access_token;	
		$token->refresh_token = $request->refresh_token;	
		$token->refresh_before = $request->refresh_before;	
		$token->last_authenticated = $request->last_authenticated;	
		$token->save();
		return true;
	}
}
