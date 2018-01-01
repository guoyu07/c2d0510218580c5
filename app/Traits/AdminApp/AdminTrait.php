<?php 

namespace App\Traits\AdminApp;

trait AdminTrait 
{
	public function admin()
	{
		return auth()->guard('admin')->user();
	}
}
