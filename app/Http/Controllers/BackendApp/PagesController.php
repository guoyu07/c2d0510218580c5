<?php

namespace App\Http\Controllers\backendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PagesController extends Controller
{
	public function getIndex(){
    return redirect('dashboard');
	}

  public function getHome(){
    return redirect('dashboard');
  }


}
