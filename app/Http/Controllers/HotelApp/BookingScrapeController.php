<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HotelApp\BookingHotelsController;

class BookingScrapeController extends Controller
{
	public $path;
	public $url;
	public $attmpt = 5;
	public $bookingHotel;

	public static function call($id)
	{
		return new BookingScrapeController($id);
	}

	public function extractRoomTypes()
	{
		$rooms = [];
		$content = $this->getStoredHtml();
		$dom = new \DOMDocument();
		$dom->recover = true;
		$dom->strictErrorChecking = false;
		$html = @$dom->loadHTML($content);
		$xpath = new \DomXPath($dom);
		$query = "//table//td[contains(@class, 'ftd')]";
		$roomRows = $xpath->query($query);
		$search = ['special', 'offer', '-', 'included', 'breakfast'];
		$remove = ['', '', '', '',''];
		foreach ($roomRows as $roomRow){
			$rooms[] = properString(trimHtml(str_replace(
										$search, $remove, strtolower($roomRow->nodeValue)
									)));
		}
		return array_values(array_unique($rooms));
	}


	public function extractRoomsBySimpleHtmlDom()
	{
		include_once app_path('MyLibrary/simple_html_dom.php');
		
		$rooms = [];

		if (strlen($this->path)) {
			$this->fileExist();
			$html = file_get_html($this->path);
			foreach ($html->find('td[class=ftd]') as $tdText) {
				$room = trim($tdText->plaintext);
				$rooms[] = $room;
			}

			$this->storeRooms($rooms);
			$this->getDbRooms();
		}

		return $this;
	}

	public function extractImages()
	{
		$html = $this->getStoredHtml();
		preg_match_all("/hotelPhotos\s*:\s*\[.*?\],/s", $html, $matches);
		$images = [];
		if (isset($matches[0][0])) {
			$images = $matches[0][0];
			$images = ltrim($images,"hotelPhotos: ");
			$images = rtrim($images,",");
			$images = fixjson($images);
			$images = json_decode($images);
		}
		return $images;
	}



	public function extractFacilities()
	{
		$facilities = [];
		$content = $this->getStoredHtml();
		$dom = new \DOMDocument();
		$dom->recover = true;
		$dom->strictErrorChecking = false;
		$html = @$dom->loadHTML($content);
		$xpath = new \DomXPath($dom);
		$query = "//div[contains(@class, 'facilitiesChecklistSection')]//span/@data-name-en";
		$data = $xpath->query($query);

		foreach ($data as $value){
			$facilities[] = trimHtml($value->nodeValue);
		}
		$diff = [
				"",
				"(Additional charge)",
				"Additional charge"
			];
		return array_values(array_unique(array_diff($facilities, $diff)));;
	}


	public function getWebHtml()
	{
		$this->url = str_replace(
							'http://', 'https://', 
							$this->bookingHotel->hotel_url
						);

		$html = null;

		// taking five attmpt
		for ($i=0; $i < $this->attmpt; $i++) { 
			if (is_null($html) || $html == '' || strlen($html) < 1) {
				$html = $this->httpGet($this->url);
			}else{
				break;
			}
		}


		$path = 'mylocal/booking/html';
		if (!file_exists(storage_path($path))) {
			mkdir(storage_path($path), 0777);
		}

		$name = explode('/', $this->url);
		$name = str_replace('.html', '', end($name));
		$this->path = saveInStorage($html, $name, 'html', $path);
		$path  = str_replace(storage_path(), '', $this->path);
		// saving in db 
		$this->bookingHotel->is_stored_room = 1;
		$this->bookingHotel->stored_path = $path;
		$this->bookingHotel->save();
		return $this;
	}

	public function getStoredHtml()
	{
		$this->fileExist();
		return trimHtml(file_get_contents($this->path));
	}

	public function fileExist()
	{
		if (!file_exists($this->path)) {
			$this->getWebHtml();
		}
		return $this;
	}


	public function setPath()
	{
		if ($this->bookingHotel->is_stored_room && strlen($this->bookingHotel->stored_path)) {

			$this->path = findWord(storage_path(), $this->bookingHotel->stored_path) 
									? $this->bookingHotel->stored_path
									: storage_path($this->bookingHotel->stored_path);
		}
		else {
			$this->getWebHtml();
		}

		$this->path = str_replace('//', '/', $this->path);
		$this->fileExist();
		return $this;
	}


	public function httpGet($url){
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}


	function __construct(int $id)
	{
		$this->bookingHotel = BookingHotelsController::call()
													->model()->findOrFail($id);
		$this->setPath();
	}


}
