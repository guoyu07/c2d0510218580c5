<div class="min-height-320">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h2>Fare : <b>{{ $result->response->price }}</b></h2>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h2>Estimate PickUp: <b>{{ $result->response->pickup_estimate }}</b> <small>(min)</small></h2>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h2>Estimate Duration: <b>{{ $result->response->trip->duration_estimate / 60 }}</b> <small>(min)</small></h2>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h2>Estimate Distance: <b>{{ $result->response->trip->distance_unit == 'mile' ? $result->response->trip->distance_estimate * 1.6 : $result->response->trip->distance_estimate }}</b> <small>(KM)</small></h2>
		</div>
	</div>
	<div class="row">
		<div id="booked_cab" class="booked-cab"></div>
	</div>
</div>
<hr class="border-top-gray">
<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-6">
		<button class="btn btn-default btn-block" onclick="hidePopUp()">Cancel</button>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-6">
		<button class="btn btn-success btn-block btn-bookCab" data-index="{{ $index }}" data-rowIndex="{{ $dbId }}">Book</button>
	</div>
</div>
