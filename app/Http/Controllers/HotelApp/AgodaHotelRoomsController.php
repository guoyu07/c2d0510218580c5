<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HotelApp\AgodaHotelsController;
use App\Http\Controllers\HotelApp\AgodaHotelImagesController;
use App\Http\Controllers\HotelApp\AgodaHotelDetailsController;
use App\Models\HotelApp\AgodaHotelRoomModel;
use App\Traits\CallTrait;

class AgodaHotelRoomsController extends Controller
{
	use CallTrait;

	public $url = '';
	public $path = '';
	public $attmpt = 5;
	public $rooms = [];
	public $images = [];
	public $isMoved = false;
	public $agodaHotel = null;
	public $agodaHotelId = null;


	public function model()
	{
		return new AgodaHotelRoomModel;
	}


	public function rooms($agodaHotelId)
	{
		$this->hotelRoom($agodaHotelId);
		return ['rooms' => $this->rooms, 'images' => $this->images()];
	}


	/*
	| finding hotel detail from db using agoda's hotel_id column 
	*/
	public function hotelRoom($agodaHotelId)
	{
		$this->agodaHotelId = $agodaHotelId;
		$result = $this->setAgodaHotel()->fatchFromDb();
		if (!is_null($this->agodaHotel) && !$this->agodaHotel->is_stored_room) {
			$result = $this->pullRooms();
		}
		return $result;
	}


	public function pullRooms()
	{
		return $this->setagodaHotel()
									->getHttpRoomHtml()
										->extractRooms()
											->extractImages()
												->fatchFromDb();
	}


	public function images()
	{
		$images = $this->images->pluck('LocationWithSquareSize2X');
		return $images->count() 
				 ? $images->toArray 
				 : [urlDefaultImageRoom()];
	}

	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($hotelId)
	{
		return $this->model()->findByHotelId($hotelId);
	}


	public function fatchFromDb($agodaHotelId = null)
	{
		$this->agodaHotelId = is_null($agodaHotelId) 
												? $this->agodaHotelId
												: $agodaHotelId;

		if ($this->agodaHotelId) {
			$this->getDbRooms();
			$this->getDbImages();
		}

		return $this;
	}


	public function getHttpRoomHtml()
	{
		$this->url = findWord('://', $this->agodaHotel->url)
							 ? $this->agodaHotel->url
							 : 'https://www.agoda.com'.$this->agodaHotel->url;

		$html = null;

		// taking five attmpt
		for ($i=0; $i < $this->attmpt; $i++) { 
			if (is_null($html) || $html == '' || strlen($html) < 1) {
				$html = $this->httpGet($this->url);
			}else{
				break;
			}
		}


		$path = 'mylocal/agoda/html';
		if (!file_exists(storage_path($path))) {
			mkdir(storage_path($path), 0777);
		}

		$name = explode('/', $this->url);
		$name = str_replace('.html', '', end($name));
		$path = saveInStorage($html, $name, 'html', $path);

		$this->path = $path;

		// check ing is moved or not;
		if ($this->checkIsMoved()) {
			return $this->getHttpRoomHtml();
		}

		$this->agodaHotel->is_stored_room = 1;
		$this->agodaHotel->stored_path = $path;
		$this->agodaHotel->save();
		return $this;
	}


	public function checkIsMoved()
	{
		include_once app_path('MyLibrary/simple_html_dom.php');
		$result = false;

		$html = file_get_html($this->path);
		
		if (is_array($html) || is_object($html)) {

			$titleObj = $html->find('title', 0);
			$title = isset($titleObj->plaintext) ? $titleObj->plaintext : '';
			$roomCol = $html->find('td[class=room_col]',0);

			if (findWord('Object moved', $title) && $this->attmpt) {
				$newUrlObj = $html->find('a', 0);
				$this->url = $newUrlObj->href;
				$this->agodaHotel->old_url = $this->agodaHotel->old_url;
				$this->agodaHotel->url = $this->url;
				$this->agodaHotel->save();
				$result = true;
				rename($this->path, $this->trashPath());
				$this->path = null;
				$this->attmpt = $this->attmpt-1;
			}
			elseif (is_null($roomCol) && $this->attmpt) {
				$result = true;
				$this->attmpt = $this->attmpt-1;
			}
		}

		return $result;
	}

	public function trashPath()
	{
		$trashPath = str_replace(
										'mylocal/agoda/html', 
										'mylocal/agoda/trash', 
										$this->path
									);
		return $trashPath;
	}
	

	public function extractRooms()
	{
		$rooms = [];

		if (strlen($this->path)) {
			include_once app_path('MyLibrary/simple_html_dom.php');

			$html = file_get_html($this->path);

			$tdTexts = $html->find('td[class=room_col]', 0);
			if (is_null($tdTexts)) {
				return $this->getHttpRoomHtml()->extractRooms();
			}

			foreach($html->find('tr') as $row) {
				$tdTexts = $row->find('td[class=room_col]',0);
				if (!is_null($tdTexts)) {
					$roomtypeObj = $tdTexts->find('span', 0);
					$roomtype = '';
					if(isset($roomtypeObj->plaintext)){
						$roomtype = $roomtypeObj->plaintext;
					}


					$imgObj = $tdTexts->find('img', 0);
					$img = '';
					if(isset($imgObj->src)){
						$img = $imgObj->src ;
					}

					$rooms[] = ['roomtype' => $roomtype, 'image' => $img];
				}
			}

			$this->storeRooms($rooms);
			$this->rooms = $rooms;
		}

		return $this;
	}


	public function storeRooms($rooms)
	{
		if (is_array($rooms)) {
			foreach ($rooms as &$room) {
				$room['hotel_id'] = $this->agodaHotel->hotel_id;
				$room['created_at'] = date('Y-m-d H:i:s');
				$room['updated_at'] = date('Y-m-d H:i:s');
			}
		}

		$this->model()->insert($rooms);
		return $this;
	}


	public function extractImages()
	{
		if (strlen($this->path)) {
			$html = file_get_contents($this->path);

			preg_match_all("/images\s*:\s*\[.*?\],/s", $html, $matches);

			$images = [];
			if (isset($matches[0][0])) {
				$images = $matches[0][0];
				$images = ltrim($images,"images: ");
				$images = rtrim($images,",");
				$images = json_decode($images);
			}
			$this->storeImages($images);
			$this->images = $images;
		}
		return $this;
	}


	public function storeImages(Array $images, $hotelId = null)
	{
		$hotelId = is_null($hotelId) ? $this->agodaHotelId : $hotelId;

		if (is_array($images)) {
			foreach ($images as &$image) {
				$image = [
						"aid" => $image->Id,
						"hotel_id" => $hotelId,
						"Title" => $image->Title, 
						"Group" => $image->Group, 
						"Location" => $image->Location, 
						"IsRoomImage" => $image->IsRoomImage,
						"LocationWithWideSize" => $image->LocationWithWideSize, 
						"LocationWithSquareSize" => $image->LocationWithSquareSize, 
						"LocationWithSquareSize2X" => $image->LocationWithSquareSize2X, 
						"created_at" => date('Y-m-d H:i:s'),
						"updated_at" => date('Y-m-d H:i:s'),
					];
			}
		}

		AgodaHotelImagesController::call()->model()
					->insert($images, $this->agodaHotel->hotel_id);
		$this->getDbImages();
		return $this;
	}


	public function getDbImages()
	{
		$this->images = AgodaHotelImagesController::call()
										->model()->findByHotelId($this->agodaHotelId);
		if (!$this->images->count()) {
			$this->setPath();
			$this->extractImages();
		}

		return $this;
	}


	public function getDbRooms()
	{
		$this->rooms = $this->isExist($this->agodaHotelId);
		if (!$this->rooms->count()) {
			$this->setPath();
			$this->extractRooms();
		}

		return $this;
	}


	public function setPath($path = null)
	{
		$this->path = $path;

		if (is_null($path)) {
			$this->setAgodaHotel();
			$check = (
					!is_null($this->agodaHotel) &&
					$this->agodaHotel->is_stored_room && 
					strlen($this->agodaHotel->stored_path)
				);
			if ($check) {
				if (is_null($this->agodaHotel->stored_path)) {
					$this->getHttpRoomHtml();
				}
				$this->path = $this->agodaHotel->stored_path;
			}
		}

		return $this;
	}


	public function setAgodaHotel($agodaHotelId = null)
	{
		$this->agodaHotelId = is_null($agodaHotelId) 
												? $this->agodaHotelId 
												: $agodaHotelId;

		if (!isset($this->agodaHotel->id) && $this->agodaHotelId) {
			$this->agodaHotel = AgodaHotelsController::call()
													->model()->hotelByAgodaId($this->agodaHotelId);	
		}

		return $this;
	}


	public function httpGet($url)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_SSL_VERIFYPEER=> false,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return $response;
	}


}
