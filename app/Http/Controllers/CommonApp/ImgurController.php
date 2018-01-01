<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\ImgurTokenModel;
use App\Traits\CallTrait;


class ImgurController extends Controller
{
	use CallTrait;


	public function upload($path)
	{
		
		$client = new \Imgur\Client;
		$client->setOption('client_id', env('IMGUR_CLIENT_ID'));
		$client->setOption('client_secret', env('IMGUR_CLIENT_SECRET'));
		$client = $this->getImgurToken($client);
		$data = base64_encode(file_get_contents($path));

		$imageData = [
				'image' => $data,
				'type'  => 'base64',
			];

		$response = $client->api('image')->upload($imageData);
		$response = is_array($response) ? collect($response) : collect();

		return ['url' => $response->get('link')];

	}



	public function getImgurToken($client)
	{
		$accessToken = ImgurTokenModel::select()
										->orderBy('id', 'desc')
											->limit(1)->first();
	
		if (is_null($accessToken)) {
			// $authUrl = $client->getAuthenticationUrl(); //use this manually 
			$code='585c3308395be095772c0fc634dbe5b9a98ddcf1'; // auto_code
			$client->requestAccessToken($code);
			$accessToken = $this->storeImgurToken($client->getAccessToken());
		}

		$client->setAccessToken($accessToken->data->toArray());

		if ($client->checkAccessTokenExpired()) {
			$client->refreshToken();
			$accessToken = $this->storeImgurToken($client->getAccessToken());
		}

		return $client;


		/*
		!!!!---- not using this

		if (isset($_SESSION['token'])) {
			$client->setAccessToken($_SESSION['token']);

			if ($client->checkAccessTokenExpired()) {
				$client->refreshToken();
			}
		} elseif (isset($_GET['code'])) {
				$client->requestAccessToken($_GET['code']);
				$_SESSION['token'] = $client->getAccessToken();
		} else {
				echo '<a href="'.$client->getAuthenticationUrl().'">Click to authorize</a>';
		}*/
	}


	public function storeImgurToken($data)
	{
		$model = new ImgurTokenModel;
		$model->data = $data;
		$model->save();
		return $model;
	}


}
