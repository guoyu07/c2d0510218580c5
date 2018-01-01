<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\TrackPackageModel;
use App\Http\Controllers\B2bApp\PackageController;
use App\Traits\CallTrait;

class TrackPackageController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new TrackPackageModel;
	}


	public function index(Request $request)
	{
		$take = $request->take ? $request->take : 100;
		$blade = ["tracks" => $this->model()->fatchTracks($take)];
		return view('b2b.protected.dashboard.pages.track.index', $blade);
	}

	/*
	| this function is to track when client opened the package
	*/
	public function opened($packageId)
	{
		$this->inactiveOld($packageId);
		$trackPackage = new TrackPackageModel;
		$trackPackage->package_id = $packageId;
		$trackPackage->save();
		return $trackPackage;
	}


	public function inactiveOld($packageId)
	{
		return TrackPackageModel::where('package_id', $packageId)
															->update(['status' => 0]);
		
	}


	public function getActiveJson()
	{
		$activeTracks = $this->model()->activeTracks();
		$tracks = [];
		if ($activeTracks->count()) {
			foreach ($activeTracks as $track) {
				$tracks[$track->package->id] = [
						"pid" => $track->package->id,
						"package_id" => $track->package->uid,
						"url" => route('openPackage',$track->package->token),
						"name" => $track->package->client->fullname,
						"date" => $track->created_at->format('Y-m-d H:i:s')
					];
			}
		}
		$tracks = json_encode(array_values($tracks));
		return $tracks;
	}


	public function trackPing($token, Request $request)
	{
		$package = PackageController::call()
								->model()->byToken($token)->first();

		$track = $this->model()->find($request->id);

		if (is_null($track)) {
			$track = $this->model();
		}

		$track->package_id = $package->id;
		$track->ip = $request->ip();
		$track->time_duration += 5;
		$track->status = 1;
		$track->save();
		return json_encode([
					"status" => 200,
					"id" => $track->id,
			]);
	}

}
