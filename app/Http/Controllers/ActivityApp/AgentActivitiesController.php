<?php

namespace App\Http\Controllers\ActivityApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\ImageModel;
use App\Models\ActivityApp\AgentActivityModel;
use App\Traits\CallTrait;

class AgentActivitiesController extends Controller
{
	use CallTrait;

	public function model()
	{
		return new AgentActivityModel;
	}
	

	public function insertOwnActivities(Array $data)
	{
		$data = collect($data);
		$agentActivity = new AgentActivityModel;
		$agentActivity->mode = $data->get('mode');
		$agentActivity->title = $data->get('title');
		$agentActivity->pick_up = $data->get('pick_up');
		$agentActivity->duration = $data->get('duration');
		$agentActivity->destination_code = $data->get('city_id');
		$agentActivity->timing = $data->get('timing');
		$agentActivity->description = $data->get('description');
		$agentActivity->inclusion = $data->get('inclusion');
		$agentActivity->exclusion = $data->get('exclusion');
		$agentActivity->is_temp = $data->get('is_temp', 0);
		$agentActivity->save();


		foreach ($data->get('images', []) as $value) {
			$image = new ImageModel([
											'type' => 'path', 
											'image_path' => $value
										]);
			$agentActivity->images()->save($image);
		}

		$agentActivity->refresh();
		return $agentActivity;
	}
}
