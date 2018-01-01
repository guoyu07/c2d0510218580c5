<?php

/**
* 
*/
	class Unique_String
	{
		function Get_String()
		{
			date_default_timezone_set('Asia/Kolkata');
			$Date_Obj 	= new DateTime();
			$Date_Array 	=  (array) $Date_Obj;
			$Current_Date 	= $Date_Array['date'];
			$TimeStamp 	= $Date_Obj->getTimestamp();

			return substr(md5(uniqid(rand(), true)),-3).substr(md5(uniqid(rand(), true)),-2).substr(md5(uniqid(rand(), true)),-3).'-'
				.substr(uniqid(md5($TimeStamp, true)),-4).'-'
				.substr(md5(uniqid(rand(), true)),-4).'-'
				.substr(md5(uniqid(rand(), true)),-4).'-'
				.substr(md5(uniqid(rand(), true)),-4).substr(md5(uniqid(rand(), true)),-4).substr(md5(uniqid(rand(), true)),-4);
		}
	}
	

?>