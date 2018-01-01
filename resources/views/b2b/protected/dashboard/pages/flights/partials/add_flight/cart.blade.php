<div class="row custom-flight-cart" data-vsid="" data-uid="A0">
	<hr class="hide">
	<div class="col-md-1 col-sm-1 col-xs-1">
		<div class="row">
			<img class="flight-logo" src="{{ urlImage('images/airlineImages/__.gif') }}" onerror="defaultAirlineIcon(this)" alt="">
		</div>
		<div class="row m-top-20 text-center">
			<a href="#" class="hide">
				<i class="fa fa-trash font-size-25 red remove-custom-flight-cart"></i>
			</a>
		</div>
	</div>
	<div class="col-md-11 col-sm-11 col-xs-11">
		<div class="row">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<input type="text" class="form-control flight-name" placeholder="Flight name.. Air India" data-code="">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<input type="text" class="form-control flight-number" placeholder="Flight No... AI401">
			</div>
		</div>

		<div class="row m-top-5">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<input type="text" class="form-control location input-airport origin inctv" placeholder="Origin">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="row">
					<div class="col-md-7 col-sm-7 col-xs-12">
						<input type="text" class="form-control has-feedback-left datetimepicker init departure-date p-left-10" data-inputmask="\'mask\': \'99/99/9999\'" placeholder="Date and time">
					</div>
					<div class="col-md-5 col-sm-5 col-xs-12">
						<input type="text" class="form-control departure-time" data-inputmask="\'mask\': \'99:99\'" placeholder="HH:MM"/>
					</div>
				</div>
			</div>
		</div>

		<div class="row m-top-5">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<input type="text" class="form-control location input-airport destination inctv" data-code="" placeholder="Destination">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="row">
					<div class="col-md-7 col-sm-7 col-xs-12">
						<input type="text" class="form-control has-feedback-left datetimepicker init arrival-date p-left-10" data-inputmask="\'mask\': \'99/99/9999\'" placeholder="Date and time">
					</div>
					<div class="col-md-5 col-sm-5 col-xs-12">
						<input type="text" class="form-control arrival-time" data-inputmask="\'mask\': \'99:99\'" placeholder="HH:MM"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>