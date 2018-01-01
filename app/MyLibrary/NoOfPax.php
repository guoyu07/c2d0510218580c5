<?php
	
	// this function will calc extra people from detault pax of a hotel room
	// perameters like 
	// 1st is $Array = ["NoOfAdults"=> 3, "NoOfChild"=>1, "ChildAge"=> [11]];
	// 2nd will be default pax like 3 or 2\
	// 3rd will be max child age like 2 or 4 in int  
	
	/**
	* 
	*/
	class NoOfPax
	{	

		function All($PerRoomGuests, $MaxAge){

			$Check = (
				isset_multi(["NoOfAdults","NoOfChild","ChildAge"],$PerRoomGuests) && 
				$PerRoomGuests['NoOfChild'] == count($PerRoomGuests['ChildAge'])
			);

			if ($Check) {

				$NoOfAdult = $PerRoomGuests['NoOfAdults'];
				$NoOfChild = $PerRoomGuests['NoOfChild'];
				$ChildAge = $PerRoomGuests['ChildAge'];
				
				$FinalNoOfChild = GetChild_Count($ChildAge, $MaxAge);
				$FinalNoOfAdult = ($NoOfAdult + $NoOfChild - $FinalNoOfChild);
				
				$Final_Array = [
					"NoOfAdults" => $FinalNoOfAdult, 
					"NoOfChild" => $FinalNoOfChild, 
				];

				return $Final_Array;
			}
			else{
				return false;
			}
		}


		function Extra($PerRoomGuests, $DefaultPax, $MaxAge){
			$Check = (
				isset($PerRoomGuests['NoOfAdult']) && 
				isset($PerRoomGuests['NoOfChild']) && 
				isset($PerRoomGuests['ChildAge'])
			);

			if ($Check) {

				$NoOfAdult = isset($PerRoomGuests['NoOfAdult']) ? $PerRoomGuests['NoOfAdult'] : '';
				$NoOfChild = isset($PerRoomGuests['NoOfChild']) ? $PerRoomGuests['NoOfChild'] : '';
				$ChildAge = isset($PerRoomGuests['ChildAge']) ? $PerRoomGuests['ChildAge'] : '';

				$Adult_and_ChildAsAdult = $NoOfAdult;
				$ExtraAdult = '';
				$ChildAsAdult = '';
				$ExtraChild = $NoOfChild;
				$TotalPax = ($NoOfAdult + $NoOfChild);

				if($NoOfAdult > $DefaultPax){
					$ExtraAdult = ($NoOfAdult - $DefaultPax);
				}
				elseif (($TotalPax)>$DefaultPax && $NoOfAdult <= $DefaultPax ) {
					$ExtraChild = ($TotalPax-$DefaultPax);
				}

				if ($ExtraChild>0) {
					$GetChild_Count = GetChild_Count($ChildAge, $MaxAge);
					if ($GetChild_Count <= $ExtraChild) {
						$ChildAsAdult = ($ExtraChild - $GetChild_Count);
						$ExtraChild = $GetChild_Count;
					};
				};

				$Final_Array = [
					"ExtraAdult" => $ExtraAdult, 
					"ExtraChildAsAdult" => $ChildAsAdult, 
					"ExtraChild" => $ExtraChild
				];

				return $Final_Array;
			}
			else{
				return false;
			}
		}

		function __construct(){
		}
	}
?>