<?php 

namespace App\Traits;

trait CallTrait 
{
	/*
	| This is function is made for. 
	| if you want to call a non static function without 
	| making object then this function will use 
	| for example $foo = BarClass::call()->foo();
	*/

	public static function call()
	{
		$class = self::class;
		return new $class;
	}
}
