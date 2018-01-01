<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\TravelportHotelModel;
use App\MyLibrary\Verdant\XML2Array;
use App\Traits\CallTrait;


class TravelportHotelController extends Controller
{
	use CallTrait;

	public $provider = '1G';
	public $credentials = '';
	public $requestPath = '';
	public $responsePath = '';
	public $targetBranch = 'P7004112';
	public $hotels = [];

	public function hotels(Array $params = [])
	{
		$params = [
				"adults" => 2,
				"location" => 'SIN',
				"hotelName" => '',
				"checkInDate" => '2017-06-17',
				"checkOutDate" => '2017-06-19',
			];

		$xmlReq = $this->makeHotelRequestXml($params);
		$xmlRsp = $this->runRequest($xmlReq);
		$result = $this->xmlToArray($xmlRsp);
		return $result;
	}

	public function fakerHotels()
	{
		$xml = file_get_contents(mylocal_path('travelport/hotels/response/1495475046_b68ef848c4613ed15cfd9fac118941da.xml'));
		$result = $this->xmlToArray($xml);
		$result = $this->makeStoreHotelArray($result);
	}

	public function hotelRooms(Array $params = [])
	{
		$params = [
				"hotelChain" => '',
				"hotelCode" => '',
				"adults" => 2,
				"location" => 'SIN',
				"name" => '',
				"checkInDate" => '2017-06-17',
				"checkOutDate" => '2017-06-19',
			];
		$xmlReq = $this->makeHotelRoomRequestXml($params);
		$xmlRsp = $this->runRequest($xmlReq);
		$result = $this->xmlToArray($xmlRsp);
		return $result;
	}


	public function media($params=[])
	{
		$params = ['hotels' => [['code'=> '85883', 'chain' => 'HL']]];
		$xmlReq = $this->makeMediaRequestXml($params);
		$xmlRsp = $this->runRequest($xmlReq);
		$result = $this->xmlToArray($xmlRsp);
		return $result;
	}

	public function makeHotelRequestXml(Array $params)
	{
		$params = (object) $params;
		
		$adults = $params->adults;
		$location = $params->location;
		$hotelName = $params->hotelName;
		$checkInDate = $params->checkInDate;
		$checkOutDate = $params->checkOutDate;

		$message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
			<soapenv:Header/>
			<soapenv:Body>
				<hot:HotelSearchAvailabilityReq xmlns:com="http://www.travelport.com/schema/common_v29_0" xmlns:hot="http://www.travelport.com/schema/hotel_v29_0" AuthorizedBy="user" TargetBranch="'.$this->targetBranch.'" TraceId="trace">
					<com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
					<hot:HotelSearchLocation>
						<hot:HotelLocation Location="'.$location.'"/>
					</hot:HotelSearchLocation>
					<hot:HotelSearchModifiers NumberOfAdults="'.$adults.'">
						<com:PermittedProviders>
							<com:Provider Code="'.$this->provider.'"/>
						</com:PermittedProviders>
						<hot:HotelName>'.$hotelName.'</hot:HotelName>
					</hot:HotelSearchModifiers>
					<hot:HotelStay>
						<hot:CheckinDate>'.$checkInDate.'</hot:CheckinDate>
						<hot:CheckoutDate>'.$checkOutDate.'</hot:CheckoutDate>
					</hot:HotelStay>
				</hot:HotelSearchAvailabilityReq>
			</soapenv:Body>
		</soapenv:Envelope>';
		$message = trimHtml($message);
		$this->saveAsFile($message, $this->requestPath());
		return $message;
	}


	public function makeHotelRoomRequestXml(Array $params)
	{
		$params = (object) $params;
		$hotelChain = $params->hotelChain;
		$hotelCode = $params->hotelCode;
		$name = $params->name;
		$adults = $params->adults;
		$checkInDate = $params->checkInDate;
		$checkOutDate = $params->checkOutDate;

		$message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
			<soapenv:Header/>
			<soapenv:Body>
				<hot:HotelDetailsReq xmlns:hot="http://www.travelport.com/schema/hotel_v40_0" xmlns:com="http://www.travelport.com/schema/common_v40_0" xmlns:hotel="http://www.travelport.com/schema/hotel_v40_0" TargetBranch="'.$this->targetBranch.'">
					<com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
					<hotel:HotelProperty HotelChain="'.$hotelChain.'" HotelCode="'.$hotelCode.'"/>
					<hotel:HotelDetailsModifiers NumberOfAdults="1" NumberOfRooms="1" RateRuleDetail="Complete">
						<com:PermittedProviders>
							<com:Provider Code="1G"/>
						</com:PermittedProviders>
						<hotel:HotelStay>
							<hotel:CheckinDate>2017-05-25</hotel:CheckinDate>
							<hotel:CheckoutDate>2017-05-30</hotel:CheckoutDate>
						</hotel:HotelStay>
					</hotel:HotelDetailsModifiers>
				</hot:HotelDetailsReq>
			</soapenv:Body>
		</soapenv:Envelope>';

		$message = trimHtml($message);
		$this->saveAsFile($message, $this->requestPath());
		return $message;
	}


	public function makeMediaRequestXml(Array $params)
	{
		$params = rejson_decode($params);
		$hotelTags = '';
		foreach ($params->hotels as $key => $hotel) {
			$hotelTags .= '<HotelProperty HotelCode="'.$hotel->code
										.'" HotelChain="'.$hotel->chain.'"/>';
		}

		$message = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
			<soapenv:Header/>
			<soapenv:Body>
				<HotelMediaLinksReq xmlns="http://www.travelport.com/schema/hotel_v40_0" TraceId="6a3a12c8-a6b6-4518-a23e-338a84e18c4b" AuthorizedBy="Travelport" TargetBranch="'.$this->targetBranch.'" SizeCode="A">
				  <BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v40_0" OriginApplication="uAPI" />
				  '.$hotelTags.'
				</HotelMediaLinksReq>
			</soapenv:Body>
		</soapenv:Envelope>';

		$message = trimHtml($message);
		$this->saveAsFile($message, $this->requestPath());
		return $message;
	}


	public function makeStoreHotelArray($data)
	{
		$hotelResult = isset($data['SOAP:Envelope']['SOAP:Body']
									 ['hotel:HotelSearchAvailabilityRsp']
									 ['hotel:HotelSearchResult'])
								 ? $data['SOAP:Envelope']['SOAP:Body']
									 ['hotel:HotelSearchAvailabilityRsp']
									 ['hotel:HotelSearchResult']
								 : [];
		$hotels = [];
		$publicHotels = [];
		foreach ($hotelResult as $hotel) {
			if (isset($hotel['hotel:HotelProperty']['@attributes']['Name'])) {

				$attributes = $hotel['hotel:HotelProperty']['@attributes'];
				$name = $attributes['Name'];

				$code = isset($attributes['HotelCode']) 
							? $attributes['HotelCode']
							: '';
				
				$chain = isset($attributes['HotelChain']) 
							 ? $attributes['HotelChain']
							 : '';

				$address = isset($hotel['hotel:HotelProperty']
											['hotel:PropertyAddress']['hotel:Address'])
								 ? $hotel['hotel:HotelProperty']
											['hotel:PropertyAddress']['hotel:Address']
								 : '';
				$location = isset($attributes['HotelLocation'])
									? $attributes['HotelLocation']
									: '';
				$rating = isset($hotel['hotel:HotelProperty']['hotel:HotelRating']
										['hotel:Rating'])
								? $hotel['hotel:HotelProperty']['hotel:HotelRating']
										['hotel:Rating']
								: '';

				$tempHotel = [
						"name" => $name,
						"code" => $code,
						"chain" => $chain,
						"image" => "",
						"latitude" => "",
						"longitude" => "",
						"description" => "",
						"city" => $location,
						"address" => $address,
						"star_rating" => $rating,
					];

				$addedAttributes = [
						"xml_path" => $this->responsePath,
						"created_at" => date('Y-m-d H:i:s'),
						"updated_at" => date('Y-m-d H:i:s')
					];
				$publicHotels[] = $tempHotel;
				$hotels[] = array_merge($tempHotel, $addedAttributes);
			}		
		}

		$this->hotels = $publicHotels;
		TravelportHotelModel::call()->insertIgnore($hotels);
		return $this->hotels;
	}


	public function xmlToArray($xml)
	{
		return XML2Array::createArray($xml);
	}


	public function runRequest($message){ 

		$soap_do = $this->initializeHeader($message); //initialize header

		// Run the request
		$result = curl_exec($soap_do);
		
		if (curl_errno($soap_do) != ''){
			return '<error>something went wrong</error>';
		}

		curl_close($soap_do);

		$this->saveAsFile($result,$this->responsePath());

		return $result;
	}

	public function saveAsFile($data, $name)
	{
		$path = mylocal_path('travelport/hotels/'.$name);
		$myfile = fopen($path, "w") or die("Unable to open file!");
		fwrite($myfile, $data);
		fclose($myfile);
		return $path;
	}


	public function initializeHeader($message){ //Initialize all the header contents
		$auth = base64_encode($this->credentials);
		// Initialize the CURL object with the uAPI endpoint URL
		$soap_do = curl_init ("https://americas.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/HotelService"); // Endpoint URL

		// This is the header of the request
		$header = array(
		"Content-Type: text/xml;charset=UTF-8", 
		"Accept: gzip,deflate", 
		"Cache-Control: no-cache", 
		"Pragma: no-cache", 
		"SOAPAction: \"\"",
		"Authorization: Basic ".$auth, 
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




	public function __construct()
	{
		$this->credentials = env('TRAVELPORT_USER_ID').':'.env('TRAVELPORT_PASSWORD');
	}

}
