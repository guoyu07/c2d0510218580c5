<?php

function json_decodeMulti($string, $is_array = true){

	$result = null;

	if (is_string($string)) {
		$json_decoded = json_decode($string,true);
		$array = [];
		if (is_array($json_decoded)) {
			foreach ($json_decoded as $je_key => $je_value) {
				$array[$je_key] = json_decodeMulti($je_value);
			}
			$result = $array;
		}
		else{
			$result = $string;
		}
	}
	elseif(is_array($string)) {
		$array = [];
		foreach ($string as $key => $value) {
			$array[$key] = json_decodeMulti($value);
		}
		$result = $array;
	}
	elseif (is_object($string)) {
		$result = json_decodeMulti(rejson_decode($string, true), $is_array);
	}
	else{
		$result = $string;
	}

	return rejson_decode($result, $is_array);
}