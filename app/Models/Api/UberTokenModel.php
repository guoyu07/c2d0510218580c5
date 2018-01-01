<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class UberTokenModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'uber_tokens';

}
