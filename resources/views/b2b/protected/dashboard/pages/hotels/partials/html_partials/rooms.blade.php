<?php
	$transfers = [
			"airport" => "Airport",
			"bus" => "Bus/Coach",
			"hotel" => "Hotel",
			"cruise" => "Cruise/Ferry",
		];

	$transfersHtml = '';
	foreach ($transfers as $transferKey => $transfer) {
		$transfersHtml .= '<option value="'.$transferKey.'">'.$transfer.'</option>';
	}
?>
<div class="row padding-10 border-gray m-top-5">
	<div class="col-md-12 col-sm-12 col-xs-12 room-container">
		<div class="row">
			{{-- Room Type Image Div  --}}
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row height-120px">
					<img src="'+roomImage+'" alt="" height="100%" width="100%">
				</div>
			</div>
			{{-- /Room Type Image Div  --}}

			{{-- Room type main Container --}}
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5">
						<div class="font-size-20">'+roomType+'</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-9">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6 pick-drop-container">
								<div class="row">
									<div class="col-md-2 col-sm-2 col-xs-2">
										<div class="checkbox">
											<label class="nopadding width-100-p">
												<input type="checkbox" class="flat" data-type="pick_up">
											</label>
										</div>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop">Add Pick-Up</div>
									<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop" style="display: none;">
										<select class="btn-block border-gray padding-5 h-pick-up"
											data-selected="0">
											<option value="">Pick-Up From?</option>
											{!! $transfersHtml !!}
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 pick-drop-container">
								<div class="row">
									<div class="col-md-2 col-sm-2 col-xs-2">
										<div class="checkbox">
											<label class="nopadding width-100-p">
												<input type="checkbox" class="flat" data-type="drop_off">
											</label>
										</div>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop">Add Drop-Off</div>
									<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop" style="display: none;">
										<select class="btn-block border-gray padding-5 h-drop-off" 
											data-selected="0">
											<option value="">Drop Off To?</option>
											{!! $transfersHtml !!}
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<button class="btn btn-block '+btnClass+' btn-bookRoom" 
									data-vdr="'+roomVdr+'" 
									data-rmid="'+roomId+'" 
									data-rmdid="'+rmdid+'" {{-- package_hotel_id --}}>'+btnName+'</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-6">
						<div class="row">
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="checkbox">
									<label class="nopadding width-100-p">
										<input type="checkbox" class="flat meal breakfast" data-type="meal" data-meal="breakfast" >
									</label>
								</div>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10">Add Breakfast</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<div class="row">
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="checkbox">
									<label class="nopadding width-100-p">
										<input type="checkbox" class="flat meal lunch" data-type="meal" data-meal="lunch" >
									</label>
								</div>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10">Add Lunch</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<div class="row">
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="checkbox">
									<label class="nopadding width-100-p">
										<input type="checkbox" class="flat meal dinner" data-type="meal" data-meal="dinner" >
									</label>
								</div>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10">Add Dinner</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>