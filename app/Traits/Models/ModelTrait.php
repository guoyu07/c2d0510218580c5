<?php 

namespace App\Traits\Models;

trait ModelTrait 
{

	/**
	 * Set the type of cast for a model attribute.
	 *
	 * @param  string  $key
	 * @param  string  $value
	 * @return $this
	 */
	public function setCastType($key, $value)
	{
		$this->casts[$key] = $value;
	}

}
