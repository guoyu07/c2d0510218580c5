<?php

namespace App\Http\Controllers\FlightApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MyLibrary\Verdant\XML2Array;
use App\Traits\CallTrait;


class TravelportAirController extends Controller
{
	use CallTrait;

	public $provider = '1G';
	public $credentials = '';
	public $requestPath = '';
	public $responsePath = '';
	public $targetBranch = 'P7004112';
	public $flights = [];



	public function flights($params=[])
	{
		/*$params = [
				"date" => "2016-06-05"
				"origin" => "DEL",
				"destination" => "SIN"
			];*/

		$xmlReq = $this->makeFlightRequestXml($params);
		$xmlRsp = $this->runRequest($xmlReq);
		$result = $this->xmlToArray($xmlRsp);
		dd($result);
		return $result;
	}

	public function makeFlightRequestXml(Array $params)
	{
		$params = (object) $params;
		$message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
		   <soapenv:Header/>
		   <soapenv:Body>
		      <air:AvailabilitySearchReq TraceId="TraceId" AuthorizedBy="user" TargetBranch="'.$this->targetBranch.'" xmlns:air="http://www.travelport.com/schema/air_v29_0" xmlns:com="http://www.travelport.com/schema/common_v29_0">
		         <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
		         <air:SearchAirLeg>
		            <air:SearchOrigin>
		               <com:Airport Code="'.$params->origin.'"/>
		            </air:SearchOrigin>
		            <air:SearchDestination>
		               <com:Airport Code="'.$params->destination.'"/>
		            </air:SearchDestination>
		            <air:SearchDepTime PreferredTime="'.$params->date.'">
		            </air:SearchDepTime>
		         </air:SearchAirLeg>
		         <air:AirSearchModifiers>
		            <air:PreferredProviders>
		               <com:Provider Code="'.$this->provider.'"/>
		            </air:PreferredProviders>
		         </air:AirSearchModifiers>
		      </air:AvailabilitySearchReq>
		   </soapenv:Body>
		</soapenv:Envelope>';
		$message = trimHtml($message);
		$this->saveAsFile($message, $this->requestPath());
		return $message;
	}

	public function index()
	{
		/* 
		* uAPI sample communication in php language 
		* 
		* This example requires the cURL library to be installed and working. 
		* 
		* Please note, in the sample code below, the variable $CREDENTIALS is created by binding your username and password together with a colon e.g. 
		* 
		* $auth = base64_encode("Universal API/API1234567:mypassword"); 
		* 
		* The variable $TARGETBRANCH should be set to the TargetBranch provided by Travelport. 
		* 
		* (C) 2014 Travelport, Inc. 
		* This code is for illustration purposes only. 
		*/
		$TARGETBRANCH = 'P105159';
		$CREDENTIALS = 'Universal API/uAPI2145928867:w3BDGEJp57WD3JHspH5kphyct';
		$Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH



		$file = "001-".$Provider."_AirAvailabilityReq.xml"; // file name to save the request xml for test only(if you want to save the request/response)

		$message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
		   <soapenv:Header/>
		   <soapenv:Body>
		      <air:AvailabilitySearchReq TraceId="TraceId" AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" xmlns:air="http://www.travelport.com/schema/air_v29_0" xmlns:com="http://www.travelport.com/schema/common_v29_0">
		         <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
		         <air:SearchAirLeg>
		            <air:SearchOrigin>
		               <com:Airport Code="SIN"/>
		            </air:SearchOrigin>
		            <air:SearchDestination>
		               <com:Airport Code="DPS"/>
		            </air:SearchDestination>
		            <air:SearchDepTime PreferredTime="2017-05-01">
		            </air:SearchDepTime>
		         </air:SearchAirLeg>
		         <air:AirSearchModifiers>
		            <air:PreferredProviders>
		               <com:Provider Code="'.$Provider.'"/>
		            </air:PreferredProviders>
		         </air:AirSearchModifiers>
		      </air:AvailabilitySearchReq>
		   </soapenv:Body>
		</soapenv:Envelope>';

		$file = "001-".$Provider."_AirAvailabilityReq.xml"; // file name to save the request xml for test only(if you want to save the request/response)

		$this->prettyPrint($message,$file);//call function to pretty print xml
		$auth = base64_encode("$CREDENTIALS"); 
		$soap_do = curl_init("https://americas.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService");
		$header = array(
			"Content-Type: text/xml;charset=UTF-8", 
			"Accept: gzip,deflate", 
			"Cache-Control: no-cache", 
			"Pragma: no-cache", 
			"SOAPAction: \"\"",
			"Authorization: Basic $auth", 
			"Content-length: ".strlen($message),
		); 
		//curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30); 
		//curl_setopt($soap_do, CURLOPT_TIMEOUT, 30); 
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($soap_do, CURLOPT_POST, true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true); // this will prevent the curl_exec to return result and will let us to capture output
		$return = curl_exec($soap_do);
		// dd_pre_echo($return);
		$file = "001-".$Provider."_AirAvailabilityRsp.xml"; // file name to save the response xml for test only(if you want to save the request/response)
		$content = $this->prettyPrint($return,$file);
		$this->parseOutput($content);
		//print '<br>';
		//echo $return;
		//print '<br>';
		//print_r(curl_getinfo($soap_do));
	}

	//Pretty print XML
	function prettyPrint($result,$file){
		$dom = new \DOMDocument;
		$dom->preserveWhiteSpace = false;
		$dom->loadXML($result);
		$dom->formatOutput = true;		
		//call function to write request/response in file	
		$this->outputWriter($file,$dom->saveXML());
		echo $dom->saveXML();
	}

	//function to write output in a file
	function outputWriter($file,$content){	
		file_put_contents($file, $content); // Write request/response and save them in the File
	}

	function parseOutput($content){	//parse the Search response to get values to use in detail request
		$AirAvailabilitySearchRsp = $content; //use this if response is not saved anywhere else use above variable
		//echo $AirAvailabilitySearchRsp;
		$xml = simplexml_load_String("$AirAvailabilitySearchRsp", null, null, 'SOAP', true);	
		
		dd($xml);
		if($xml)
			echo "Processing! Please wait!";
		else{
			trigger_error("Encoding Error!", E_USER_ERROR);
		}

		$Results = $xml->children('SOAP',true);
		foreach($Results->children('SOAP',true) as $fault){
			if(strcmp($fault->getName(),'Fault') == 0){
				trigger_error("Error occurred request/response processing!", E_USER_ERROR);
			}
		}
		
		$count = 0;
		$fileName = "flights.txt";
		if(file_exists($fileName)){
			file_put_contents($fileName, "");
		}
		foreach($Results->children('air',true) as $nodes){
			foreach($nodes->children('air',true) as $hsr){
				if(strcmp($hsr->getName(),'AirSegmentList') == 0){
					foreach($hsr->children('air',true) as $hp){
						if(strcmp($hp->getName(),'AirSegment') == 0){
							$count = $count + 1;
							file_put_contents($fileName,"\r\n"."Air Segment ".$count."\r\n"."\r\n", FILE_APPEND);
							foreach($hp->attributes() as $a => $b	){
									$GLOBALS[$a] = "$b";
									//echo "$a"." : "."$b";
									file_put_contents($fileName,$a." : ".$b."\r\n", FILE_APPEND);
							}												
						}					
					}
				}
				//break;
			}
		}
		$Token = 'Token';
		$TokenKey = 'TokenKey';
		$fileName = "tokens.txt";
		if(file_exists($fileName)){
			file_put_contents($fileName, "");
		}
		foreach($Results->children('air',true) as $nodes){
			foreach($nodes->children('air',true) as $hsr){
				if(strcmp($hsr->getName(),'HostTokenList') == 0){			
					foreach($hsr->children('common_v29_0', true) as $ht){
						if(strcmp($ht->getName(), 'HostToken') == 0){
							$GLOBALS[$Token] = $ht[0];
							foreach($ht->attributes() as $a => $b){
								if(strcmp($a, 'Key') == 0){
									file_put_contents($fileName,$TokenKey.":".$b."\r\n", FILE_APPEND);
								}
							}						
							file_put_contents($fileName,$Token.":".$ht[0]."\r\n", FILE_APPEND);
						}
					}
				}
			}
		}
		
		echo "\r\n"."Processing Done. Please check results in files.";
	}


	public function xmlToArray($xml)
	{
		return XML2Array::createArray($xml);
	}




	public function saveAsFile($data, $name)
	{
		$path = mylocal_path('travelport/flights/'.$name);
		$myfile = fopen($path, "w") or die("Unable to open file!");
		fwrite($myfile, $data);
		fclose($myfile);
		return $path;
	}


	public function requestPath()
	{
		$this->requestPath = 'request/'.timestamp().'_'
													.mycrypt(timestamp()).'.xml';

		return $this->requestPath;

	}


	public function responsePath()
	{
		$this->responsePath = 'response/'.timestamp().'_'
													.mycrypt(timestamp()).'.xml';
		return $this->responsePath;
	}



	public function initializeHeader($message){ 

		$auth = base64_encode($this->credentials);
		// Initialize the CURL object with the uAPI endpoint URL
		$soap_do = curl_init("https://americas.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService");

		// This is the header of the request
		$header = array(
			"Content-Type: text/xml;charset=UTF-8", 
			"Accept: gzip,deflate", 
			"Cache-Control: no-cache", 
			"Pragma: no-cache", 
			"SOAPAction: \"\"",
			"Authorization: Basic $auth", 
			"Content-length: ".strlen($message),
		); 
		
		//curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30); // Timeout options
		//curl_setopt($soap_do, CURLOPT_TIMEOUT, 30); 
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false); // Verify nothing about peer certificates
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); // Verify nothing about host certificate
		curl_setopt($soap_do, CURLOPT_POST, true ); 
		curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message); 
		curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);

		return $soap_do;
	}

	public function runRequest($message){ 

		$soap_do = $this->initializeHeader($message); //initialize header

		// Run the request
		$result = curl_exec($soap_do);
		
		if (curl_errno($soap_do) != ''){
			return '<error>'.curl_errno($soap_do).'</error>';
		}

		curl_close($soap_do);

		$this->saveAsFile($result,$this->responsePath());

		return $result;
	}


	public function __construct()
	{
		$this->credentials = env('TRAVELPORT_USER_ID').':'.env('TRAVELPORT_PASSWORD');
	}

}
