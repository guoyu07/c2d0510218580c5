<?php

function mydata($data = []){
	return new \App\MyLibrary\MyData($data);
}


function getRemoteIp()
{
	return getenv('HTTP_CLIENT_IP')?:
	getenv('HTTP_X_FORWARDED_FOR')?:
	getenv('HTTP_X_FORWARDED')?:
	getenv('HTTP_FORWARDED_FOR')?:
	getenv('HTTP_FORWARDED')?:
	getenv('REMOTE_ADDR');
}

function addDateColumns(Array $data)
{
	$data["created_at"] = date('Y-m-d H:i:s');
	$data["updated_at"] = date('Y-m-d H:i:s');
	return $data;
}

function longenough($word){
    return strlen( $word ) > 3;
}

function mylocal_path($path)
{
	return base_path('storage/mylocal/'.$path);
}


function loopImages(Array $data, Array $images, $type = 'object')
{
	$count = 0;
	foreach ($data as $key => &$value) {
		if ($key >= count($images)) {
			$count = 0;
		}

		$value['image'] = $images[$count];
		$count++;
	}
	if ($type == 'json') {
		$data = json_encode($data);
	}
	elseif ($type == 'object') {
		$data = rejson_decode($data);
	}
	return $data;
}



function properString($string)
{
	$string = proper($string);
	$search = ['To', 'Or', 'And', 'Of', 'With'];
	$replace = ['to', 'or', 'and', 'of', 'with'];
	return str_replace($search, $replace, $string);
}




/*
| this function is save image locally and then send a http request
| to another server then that server download the image using copy or 
| file_get_contents then it returns path of the remote dir 
| remote url is image.trawish.com
*/
function imageUpload($image)
{
	$imageName = md5(uid()).'.'.$image->getClientOriginalExtension();
	$image->move(base_path('public/images/tmp'), $imageName);
	$postUrl = 'http://'.env('IMAGE_DOMAIN').'/image/download';
	$url = url('images/tmp/'.$imageName);
	$name = httpPost($postUrl, ['url' => $url]);
	if (file_exists(base_path('public/images/tmp/').$imageName)) {
		unlink(base_path('public/images/tmp/').$imageName);
	}
	return $name;
}


function trashImage($path)
{
	$url = 'http://'.env('IMAGE_DOMAIN').'/image/trash';
	return httpPost($url, ['path' => $path]);
}




function travelFeed(){
	$url = 'http://www.travelbizmonitor.com/Includes/xmlInclude/Travelbizmonitorrss.xml';
	$response = httpGet($url);
	$response = rejson_decode(simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA));
	return $response;
}



/*
| this function is to get 
*/
function getPax($roomGuests){
	$roomGuests = rejson_decode($roomGuests, true);
	$result = '';

	if (bool_array($roomGuests)) {

		$result = ["NoOfAdults" => 0,"NoOfChild" => 0, "ChildAge" => []];
		foreach ($roomGuests as $key => $value) {
			$result['NoOfAdults'] += isset($value['NoOfAdults']) ? $value['NoOfAdults'] : 0;
			if (isset($value->ChildAge)) {
				$result['ChildAge'] = array_merge($result['ChildAge'], $value['ChildAge']); 
			}
		}
		$result['NoOfChild'] = count($result['ChildAge']);
	}

	return rejson_decode($result);
}


if (!function_exists('temp_guest_details')) {
	function temp_guest_details(){
		return [
						"adults" => 2, 
						"kids" => 0,
						"kids_age" => []
					];
	}
}


function getPackageId($id = 0){
	return 'FGF'.str_pad($id, 5, '0', STR_PAD_LEFT);
}


function getUniqueId($id, $prefix = '', $count = 5){
	return $prefix.str_pad($id, $count, '0', STR_PAD_LEFT);
}


function saveInFile($data = 'NoData', $name = '', $extn = 'txt', $path = 'test/SaveInFile'){

	$myfile = fopen($path.'/'.$name.'_'.timestamp().".".$extn, "w") or die("Unable to open file!");
	fwrite($myfile, $data);
	fclose($myfile);
}


function saveInStorage($data = 'NoData', $name = '', $extn = 'txt', $path = 'test/SaveInFile', $withTimeStamp = true){
	$path = storage_path($path);

	if (!file_exists($path)) {
		mkdir($path, 0777);
	}

	$filePath = $path.'/'.$name;

	if ($withTimeStamp) {
		$filePath = $filePath.'_'.timestamp();
	}

	$filePath = $filePath.".".$extn;

	$myfile = fopen($filePath, "w") or die("Unable to open file!");
	fwrite($myfile, $data);
	fclose($myfile);
	return $filePath;
}



/*=====================default image=====================*/
function urlImage($path = '/')
{
	$path = ltrim($path,'/');
	$array = explode('/', $path);

	if (isset($array[0]) && $array[0] != 'storage') {
		$path = 'storage/'.$path;
	}
	
	$storageUrl = 'http://'.env('IMAGE_DOMAIN');
	return str_replace(url('/'), $storageUrl, url($path));
}



function flightImage($code = null)
{
	return urlImage('images/airlineImages/'.$code.'.gif');
}


/*
| this function is to fix skyscanner images array
*/
function ssImageArrayFix($images = [], $imageHost = '')
{
	$images = rejson_decode($images, true);
	$result = [];
	foreach ($images as $ikey => $iValues) {
		$types = array_keys($iValues);
		if (isset($types[0])) {
			$result[] = 'http://'.$imageHost.$ikey.$types[0];
		}
	}
	return $result;
}
	

function activityMode($key)
{
	$found = null;
	$modes = [
			 'sic' => 'SIC',
			 'no'  => 'No Transfer',
			 'private' => 'Private',
			 'selfdrive' => 'Self Drive'
		];

	if (isset($modes[$key])) {
		$found = $modes[$key];
	}
	return $found;
}


function activityTiming($key)
{
	$found = null;
	$timing = [
			'noon' => 'Noon',
			'morning'	=> 'Morning', 
			'evening'	=> 'Evening', 
			'halfday' => 'Half Day',
			'fullday' => 'Full Day'
		];

	if (isset($timing[$key])) {
		$found = $timing[$key];
	}
	return $found;
}




// =====================common asset url=====================

function commonAsset($path){
	return asset('common/'.$path);
}


function urlReport(){
	return url('dashboard/report/submit');
}


function urlDefaultImageRoom(){
	return urlImage('images/default/room.png');
}

function urlDefaultImageHotel(){
	return urlImage('images/default/hotel.png');
}

function urlDefaultImageCruise(){
	return urlImage('images/default/hotel.png');
}

function urlDefaultImageActivity(){
	return urlImage('images/default/activity.png');
}

function urlDefaultImageProfile($value='')
{
	return urlImage('images/default/profile.jpg');
}


function  urlImageAirline($airlineCode='')
{
	$airlineCode = $airlineCode == '' ? '__' : $airlineCode;
	return urlImage('images/airlineImages/'.$airlineCode.'.gif');
}


/*======================Event Url======================*/
function urlPackageEvent($routeDbId){
	return url('/dashboard/package/event/'.$routeDbId);
}


// function urlRouteCreate($clientId)
// {
// 	return url('/dashboard/package/route/'.$clientId);
// }

/*=====================Package Url=====================*/

// function urlPackageOpen($token){
// 	return url('dashboard/package/open/'.$token);
// }


/*=====================Accommodation Url=====================*/
function urlAccomoBuilder($slug = ''){
	return url('dashboard/package/builder/accommodation/'.$slug);
}

function urlAccomoApi($slug = ''){
	return url('api/package/accommodation/'.$slug);
}

/*=====================Hotel Url=====================*/
function urlAllHotelsBuilder($packageDbId = 0){
	return url('dashboard/package/builder/hotels/'.$packageDbId);
}

function urlHotelsBuilder($slug = ''){
	return url('dashboard/package/builder/hotels/'.$slug);
}

function urlHotelsRoomBuilder($firstCartId = 0){
	return url('dashboard/package/builder/hotel/room/'.$firstCartId);
}

function urlHotelsRoomBookBuilder($firstCartId = 0){
	return url('dashboard/package/builder/hotel/room/book/'.$firstCartId);
}


function urlTbtqResult($firstCartId = "")
{
	return url('/t/hotels/result')."/".$firstCartId;
}

function urlSsResult($firstCartId = "")
{
	return url('/ss/hotels/result/'.$firstCartId);
}

/*=====================Cruises Url=====================*/

function urlAllCruisesBuilder($packageDbId = 0){
	return url('dashboard/package/builder/cruises/'.$packageDbId);
}

function urlCruisesBuilder($id = 0, $packageDbId = 0, $firstCartId = 0){
	return url('dashboard/package/builder/cruise/'.$firstCartId);
}

function urlCruisesCabinBuilder($id = 0, $packageDbId = 0, $firstCartId = 0){
	return url('dashboard/package/builder/cruise/cabin/'.$id.'/'.$packageDbId.'/'.$firstCartId);
}

function urlCruisesCabinBookBuilder($id = 0, $packageDbId = 0, $firstCartId = 0){
	return url('dashboard/package/builder/cruise/cabin/book/'.$id.'/'.$packageDbId.'/'.$firstCartId);
}


/*=====================Flights Url=====================*/
function urlFlightsBuilder($packageDbId = 0){
	return url('dashboard/package/builder/flights/'.$packageDbId);
}

function urlFlightsSearch($flightDbId = 0){
	return url('dashboard/package/builder/flight/'.$flightDbId);
}

function urlFlightsResult($flightDbId = 0){
	return url('dashboard/package/builder/flight/result/'.$flightDbId);
}


function urlFlightBook($flightDbId='')
{
	return url('/dashboard/package/builder/flight/book')."/".$flightDbId;
}


/*=====================Activities Url=====================*/

function urlActivitiesBuilder($slug){
	return url('dashboard/package/builder/activities/'.$slug);
}



/*=====================Car Url=====================*/

function urlCarsBuilder($packageDbId = 0){
	return url('dashboard/package/builder/car/'.$packageDbId);
}



/*=========================Pdf Url=========================*/

function urlPdfPacakge($packageDbId){
	return url('dashboard/package/pdf/'.$packageDbId);
}

/*===================== Responce Json =====================*/

function jsonError($error = null){
	return json_encode(error500($error));
}

function jsonResponse($status = 200, $response = 'ok', $data = [])
{
	$array = [
		"status" => $status,
		"response" => $response,
	];
	$array = array_merge($array, $data);
	return json_encode($array);
}


function error500($error='')
{
	$error = is_null($error) 
			 ? "Something Went Wrong please try again later." 
			 : $error;

	return ["status" => 500, "error" => $error];
}

/*====================Activity Function====================*/
/*
| this function is return price if sic price is available the it return 
| sic price eles it return private price id not private then it return 0
*/
function is_sic($NoOfPax, $object){
	$object = rejson_decode($object);
	$adultCount = $NoOfPax->NoOfAdults; 
	$childCount = $NoOfPax->NoOfChild;
	$result = 0;
	
	if (isset($object->Sic->Price->Adult) && isset($object->Sic->Price->Child)) {
		$result = ($object->Sic->Price->Adult*$adultCount)
						+ ($object->Sic->Price->Child*$childCount);
	}
	elseif (isset($object->Private->Price->Adult) && isset($object->Private->Price->Child) && isset($object->Private->Cars[0])) {
		$result =  ($object->Private->Price->Adult*$adultCount)
							+($object->Private->Price->Child*$childCount)
							+(2*requireCar($NoOfPax)*(ifset($object->Private->Cars[0]->Price)));
	}

	return $result;
}


function pdfHotelDesc($html){
	return str_replace(['<b>', '</b> <br />'], ['<b class="capitalize">', '</b>'], $html);
}


function starRating($count){
	$stars = '';
	$star = '<i class="fa fa-star font-size-13"></i>';
	$goldStar = '<i class="fa fa-star font-gold font-size-13"></i>';

	if (is_numeric($count)) {
		$stars = str_repeat($goldStar, $count)
						.str_repeat($star, 5-$count);
	}
	return $stars;
}

function getStarImage($count, $width = 18, $height = 18){
	
	global $Server_Name;
	
	$html = '';
	for($x = 1; $x <= $count; $x++) {
		$html .= '<img src="/images/icon/star.gif" width="'.$width.'" height="'.$height.'">';
	}
	
	return $html;
}






// this is function is for checking how many car need for travel on pax count
function requireCar($NoOfPax){
	return ceil(($NoOfPax->NoOfAdults+$NoOfPax->NoOfChild)/4);
}

function sortById($x, $y) {
	return $x['id'] - $y['id'];
}

function sortBySeatingCapacity($x, $y) {
	return $x['SeatingCapacity'] - $y['SeatingCapacity'];
}



function statusCssBorder($id)
{
	$css = '';
	if ($id == 0) {
		$css = 'red';
	}
	elseif($id == 1) {
		$css = 'green';
	}
	elseif($id == 2) {
		$css = 'font-orenge';
	}
	elseif($id == 3) {
		$css = 'font-orenge';
	}
	return $css;
}




function exitView($url = null)
{
	if ($url == null) {
		$url = urlReport();
	}
	$blade = ["url" => $url];
	exit(view('errors.404', $blade)->render());
}


function wrongView($url=null)
{
	if ($url == null) {
		$url = urlReport();
	}
	$blade = ["url" => $url];
	exit(view('errors.404', $blade)->render());
}



function myView($path, $data = [])
{
	return trimHtml(view($path, $data)->render());
}


function backendTypes($type = "", $option = true)
{
	$types = [
			"user" 	=> "User",
			"admin" => "Admin",
			"su" 		=> "Super User",
		];

	if ($option) {
		$options = '';

		foreach ($types as $key => $value) {
			$selected = $key == $type ? 'selected' : '';
			$options .= '<option value="'.$key.'" '
									.$selected.'>'.$value.'</option>';
		}

		$types = $options;
	}

	return $types;
}


function statusCss($id)
{
	$css = '';
	if ($id == 0) {
		$css = 'red';
	}
	elseif($id == 1) {
		$css = 'green';
	}
	elseif($id == 2) {
		$css = 'font-orenge';
	}
	elseif($id == 3) {
		$css = 'font-orenge';
	}
	return $css;
}

