<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CarApp\SkyscannerCarsApiController;
use App\Models\B2bApp\PackageCarModel;
use App\Traits\CallTrait;

class CarsController extends Controller
{
	use CallTrait;
	public $viewPath = 'b2b.protected.dashboard.pages.car';

	public function model()
	{
		return new PackageCarModel;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view($this->viewPath.'.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 | this function is to insert or create new row in db
	 */
	public function create($pid)
	{
		$package = PackageController::call()
							->model()->usersFind($pid);
		$blade = [
				"package" => $package,
				"client" => $package->client,
				"urlVariable" => (object)["packageDbId" => $pid]
			];

		return view($this->viewPath.'.create', $blade);
	}


	/*
	| this function is to create new hotel table row using route data 
	*/
	public function createByPackageId($pid, $data)
	{
		$packageCarModel = new PackageCarModel;
		$packageCarModel->package_id = $pid;
		$packageCarModel->request = $data->request;
		$packageCarModel->skyscanner_car_id = $data->result->db->id;
		$packageCarModel->status = 'active';
		$packageCarModel->save();
		return $packageCarModel->id;
	}


		/*
	| this function is to find all data behalf of package table id  
	*/
	public function findByPackageId($pid, $column='*', Array $where = [])
	{
		$where = array_merge([
									"package_id" => $pid,
								], $where);

		return PackageCarModel::select($column)->where($where)->get();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($pid, Request $request)
	{

		$packageCarModel = PackageCarModel::find($request->pcid);

		if (!is_null($packageCarModel) && $packageCarModel->package_id == $pid) {
			$packageCarModel->status = 'inactive';
			$packageCarModel->save();
		}
	}


	/*
	| this function is to getting cars result usign post method 
	*/
	public function postCar($pid, Request $request)
	{
		
		//return $this->fakePostCars();// this function is to get fake data use in offline

		$params = (object)$request->input();
		
		$gotCars = false;
		$skyscannerCars = [];
		$attempt = 2;

		// taking two attempt here
		for ($i=1; $i < $attempt ; $i++) { 
			if (!$gotCars) {
				$skyscannerCars = SkyscannerCarsApiController::call()->cars($params);
			}

			if (empty($skyscannerCars->cars)) {
				if ($i == 2) {
					$params->market = 'US';
				}
			}
		}

		$packageCarModelId = $this->createByPackageId($pid, (object)[
				"request" => $params,
				"result" => $skyscannerCars
			]);

		$skyscannerCars->db->package_car_id = $packageCarModelId;
		return json_encode($skyscannerCars);
	}


	public function chooseCar($pid, Request $request)
	{

		$packageCarModel = PackageCarModel::find($request->pcid);

		$returnArray = (object)[ 
				"status" => '',
				"response" => '',
				"packageUrl" => route('openPackage', 
					[$packageCarModel->package->token]),
			];

		if (!is_null($packageCarModel) && $packageCarModel->package_id == $pid) {
			$returnArray->status = 200;
			$returnArray->response = "ok";
			
			$packageCarModel->status = 'complete';

			if (!is_null($packageCarModel->skyScannerCar) && $request->vendor == 'ss') {
				$packageCarModel->selected_car_vendor = 'ss';
				$packageCarModel->skyScannerCar->selected_index = $request->index;
				$packageCarModel->skyScannerCar->save();
			}// if any other vendor then add here
		}
		else{
			$returnArray->status = 500;
			$returnArray->response = "Something went wrong";
		}

		$packageCarModel->save();

		return json_encode($returnArray);
	}


	public function postMenu($pid)
	{
		$carsData = $this->findByPackageId($pid, '*', ['status' => 'complete']);
		$cars = [];

		foreach ($carsData as $car) {
			$request = $car->request;
			if ($car->selected_car_vendor == 'ss') {
				$skyScannerCar = $car->skyScannerCar->result;
				$selectedCar = $skyScannerCar->cars[$car->skyScannerCar->selected_index];

				$cars[] = [
					"pcid" => $car->id,
					"name" => $selectedCar->vehicle,
					"seats" => $selectedCar->seats,
					"doors" => $selectedCar->doors,
					"car_type" => $selectedCar->sipp,
					"end_place" => $request->end_place,
					"start_place" => $request->start_place,
					"price_all_days" => $selectedCar->price_all_days,
					"air_conditioning" => $selectedCar->air_conditioning,
					"vendor" => 'ss',
					"selected_vendor_id" => $car->skyScannerCar->id,
					"image" => $selectedCar->image_url,
				];
			}
		}
		return json_encode($cars);
	}

	public function fakePostCars($value='')
	{
		$json = file_get_contents(public_path('cars.json'));
		$recoveredData = json_decode($json);
		$images = [];

		foreach ($recoveredData->images as $image) {
			$images[$image->id] = $image->url;  
		}

		$recoveredData->formatted_images = $images;

		foreach ($recoveredData->cars as &$car) {
			$car->image_url = ifset($images[$car->image_id], $images[0]);
		}

		return json_encode($recoveredData);
	}


}

