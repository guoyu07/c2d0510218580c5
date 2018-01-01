<?php
	// $transfers = [
	// 		"airport" => "Airport",
	// 		"bus" => "Bus/Coach",
	// 		"hotel" => "Hotel",
	// 		"cruise" => "Cruise/Ferry",
	// 	];

	// $transfersHtml = '';
	// foreach ($transfers as $transferKey => $transfer) {
	// 	$transfersHtml .= '<option value="'.$transferKey.'">'.$transfer.'</option>';
	// }

	$transfersHtml = indication()->htmlOptions('transfer_spot');
?>
<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-6 pick-drop-container">
		<div class="row">
			<div class="col-md-2 col-sm-2 col-xs-2">
				<div class="checkbox">
					<label class="nopadding width-100-p">
						<input type="checkbox" class="flat" data-type="pick_up" '+showIsChecked(accomo.is_pick_up)+'>
					</label>
				</div>
			</div>
			<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop">Add Pick-Up</div>
			<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop" style="display: none;">
				<select class="btn-block border-gray p-2-5 h-pick-up transfer"
					data-selected="0">
					<option value="">Pick-Up</option>
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
						<input type="checkbox" class="flat" data-type="drop_off" '+showIsChecked(accomo.is_drop_off)+'>
					</label>
				</div>
			</div>
			<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop">Add Drop-Off</div>
			<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop" style="display: none;">
				<select class="btn-block border-gray p-2-5 h-drop-off transfer" 
					data-selected="0">
					<option value="">Drop Off</option>
					{!! $transfersHtml !!}
				</select>
			</div>
		</div>
	</div>
</div>