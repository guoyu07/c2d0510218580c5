<?php

/*

This class for post data on API

*/

class CurlPost{	

	public function post_Json($url,$data_string = ''){

		$ch = curl_init($url);		  
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");		 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);	  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		  
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(			  
			'Content-Type: application/json',					
			'Content-Length: ' . strlen($data_string))		   
		);													   
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;

	}

	public function post_Data($url,$data = ''){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 6);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	public function post_FGF($url,$data = ''){
		// echo $url;
		$data_string = json_encode($data);

		$ch = curl_init($url);		  
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");		 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);	  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		  
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(			  
			'Content-Type: application/json',					
			'Content-Length: ' . strlen($data_string))		   
		);													   
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;

	}

	public function post_TBTQ($url,$data = ''){

		$field = json_encode($data);
		//open connection
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$field);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length:'.strlen($field)));
		//execute post
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,60);
		$result = curl_exec($ch);
		//echo $data; 
		//$arr = json_decode($data,true);
		//close connection
		curl_close($ch);
		//echo "function";
		return $result;
		//echo $data;
	}	

	function __construct(){

	}
}



?>