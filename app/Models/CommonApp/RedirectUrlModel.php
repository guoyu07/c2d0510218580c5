<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;


class RedirectUrlModel extends Model
{
  use CallTrait;

  protected $connection = 'mysql2';
  protected $table = 'redirect_urls';
  protected $fillable = ['status', 'user_id'];


  public function setStatusAttribute($value)
  {
    $this->attributes['status'] = strtolower($value);
  }


  public function findByHashId($hashId){
    // $auth = auth()->user();
  	$result = $this->select(["id", "hash_id", "token", "url"])
    	  							->where([
      											"hash_id" => $hashId, "status" => "active", 
      	  								])
      	  							->first();
  	return $result;
  }

}
