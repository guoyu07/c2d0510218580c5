<?php

namespace App\Models\CruiseApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;
use DB;

class CruisePriceModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql5';
	protected $table = 'cruise_prices';
	
	public function pullCruise(Array $params)
	{
		$params = rejson_decode($params);
		$totalPax = $params->adultCount + count($params->childAge);

		$sqlQuery = (
				"SELECT 
					y.*, 
					x.fare_adult_promotional AS fareAdultPromotional, 
					x.fare_extra_adult AS fareExtraAdult, 
					x.fare_adult AS fareAdult,
					x.default_pax*(x.fare_adult+y.portCharges) AS roomPrice,

					IF (x.fare_adult_promotional = NULL, NULL, x.default_pax*(x.fare_adult_promotional+y.portCharges)) AS promotionRoomPrice,
					
					x.default_pax AS defaultPax, 
					x.min_pax AS minPax, 
					x.max_pax AS maxPax, 
					x.room_type AS roomType
				FROM cruise_prices x
				JOIN(
					SELECT 
						V.id AS resultIndex,
						CONCAT(V.Prefix,LPAD(V.ID, 5, '0')) AS cruiseCode, 
						V.company_name AS cruiseName, 
						V.company_url AS cruiseUrl, 
						V.star_rating AS starRating, 
						V.description, V.policy, 
						V.contact_number AS contactNumber, 
						V.fax_number AS faxNumber, 
						V.email, V.address, V.pincode, 
						V.latitude, V.longitude, 
						V.cancellation_allowed AS cancellationAllowed,
						D.port_charges AS portCharges, 
						MIN(P.fare_adult) AS minFareAdult,
						V_I.images
					FROM vendor_details V
					LEFT JOIN cruise_dates D ON V.ID = D.vendor_detail_id
					LEFT JOIN (
						SELECT 
							I.relationId AS I_relationId, 
							CONCAT('[',GROUP_CONCAT( CONCAT('{\"type\":\"', I.type,'\",\"path_or_url\":\"', I.path_or_url, '\"}') ),']') AS images

						FROM `images` I
						GROUP BY I_relationId
					) V_I ON V_I.I_relationId = CONCAT(V.Prefix,V.ID)

					JOIN cruise_prices P ON V.ID = P.vendor_detail_id
					WHERE
						V.destination_code = '$params->city_id' AND
						D.date = '$params->checkInDate' AND
						D.nights = '$params->nights' AND
						P.status = 'Active' AND 
						P.day_name = DAYNAME('$params->checkInDate') AND 
						P.nights = '$params->nights' AND  
						P.max_pax >= '$totalPax' AND
						P.from_date <= '$params->checkInDate' AND
						P.to_date >= '$params->checkInDate'
					GROUP BY V.id 
				 ) y
			ON y.resultIndex = x.vendor_detail_id
			AND y.minFareAdult = x.fare_adult;"
			);
		// pre_echo($sqlQuery);
		
		DB::connection('mysql2')->statement('SET SESSION group_concat_max_len = 1000000');
		$result = DB::connection('mysql2')->select(DB::raw($sqlQuery));
		// dd_pre_echo($result);

		foreach ($result as $key => &$value) {
			$images = json_decode($value->images);
			$value->images = [];

			if (is_array($images)) {
				foreach ($images as $image) {
					if ($image->type == 'path') {
						$value->images[] = urlImage($image->path_or_url);
					}else{
						$value->images[] = $image->path_or_url;
					}
				}
			}
		}

		// dd_pre_echo($result);

		return $result;
	}

	public function pullCruiseCabin(Array $params)
	{
		$params = rejson_decode($params);
		$totalPax = $params->adultCount + count($params->childAge);

		$sqlQuery = (
				"SELECT 
					P.id,
					D.port_charges AS portCharges, 
					P.room_type AS roomType, 
					P.default_pax AS defaultPax, 
					P.fare_adult AS fareAdult, 
					P.fare_adult_promotional AS fareAdultPromotional, 
					P.fare_extra_adult AS fareExtraAdult,
					P.default_pax*(P.fare_adult+D.port_charges) AS roomPrice,

					IF (P.fare_adult_promotional = NULL, NULL, (D.port_charges+P.fare_adult_promotional)*P.default_pax) AS promotionRoomPrice
				FROM cruise_prices P
				LEFT JOIN (
					SELECT 
						CD.vendor_detail_id AS CD_vendor_detail_id, CD.port_charges
					FROM cruise_dates CD 
					WHERE 
						CD.date = '$params->checkInDate' AND
						CD.nights = '$params->nights'
					GROUP BY CD_vendor_detail_id
				) D ON D.CD_vendor_detail_id = P.vendor_detail_id
				WHERE 
					P.vendor_detail_id = '$params->resultIndex' AND
					P.status = 'Active' AND 
					P.day_name = DAYNAME('$params->checkInDate') AND 
					P.nights = '$params->nights' AND  
					P.max_pax >= '$totalPax' AND
					P.from_date <= '$params->checkInDate' AND
					P.to_date >= '$params->checkInDate'
				ORDER BY P.fare_adult ASC"
			);

		// echo $sqlQuery;
		
		$result = DB::connection('mysql2')->select(DB::raw($sqlQuery));
		return $result;

	}



}