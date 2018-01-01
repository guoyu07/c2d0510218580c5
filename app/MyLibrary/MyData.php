<?php 
	namespace App\MyLibrary;

	/**
	* this class for data object use this class if you 
	* don't want any error while pulling key from any 
	* object or array 
	*/

	class MyData
	{
		protected $data  = [];

		public function __get($name)
		{
			if (isset($this->data[$name])) {
				return $this->data[$name];
			}
			elseif (isset($this->$name)) {
				return $this->$name;
			}
			else {
				return null;
			}
		}

		function __construct(Array $data = [])
		{
			$this->data = $data;
		}
	}

