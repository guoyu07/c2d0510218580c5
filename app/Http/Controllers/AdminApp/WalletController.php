<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
	public function addMoney(Request $request)
	{
		$blade = ['request' => $request];
		return view('admin.protected.dashboard.pages.add_money.index', $blade);
	}


}
