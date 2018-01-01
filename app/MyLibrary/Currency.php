<?php
	
	/**
	* 
	*/
	class Currency{

		public function Exchange($From, $To){
			$Curl_Post_Obj = new Curl_Post();
			$url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22'.$From.$To.'%22)&env=store://datatables.org/alltableswithkeys';
			$Xml_Data = $Curl_Post_Obj->post_Data($url);
			$Result = [];
			$Exchange_Array = json_decode(Xml_to_Json($Xml_Data),TRUE);
			
			if ($Exchange_Array != '') {
				$Result = Move_ArrayUp(Move_ArrayUp($Exchange_Array));
				$Result['ID'] = isset($Result['@attributes']['id']) ? $Result['@attributes']['id'] : '';
				unset($Result['@attributes']);
			};

			return $Result;
		}

		function __construct(){
		}
	}


?>