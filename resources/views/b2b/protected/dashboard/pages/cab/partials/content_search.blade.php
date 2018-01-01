{{-- Cab Serach --}}
<div class="col-md-3 col-md-3 col-xs-12">
	<div class="x_panel">
		<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left height-50vh">
			<div class="x_title">
				<h2><div class="text-center"><i class="fa fa-cab"></i> Cab Search</div></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content m-top-10-only">
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-15-only">
						<input type="text" class="form-control input-airport origin txtautocomplete" id="origin" placeholder="Origin" name="origin" data-lat="" data-long="" >
						<i class="fa fa-map-marker form-control-feedback right-1 right" aria-hidden="true"></i>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-15-only">
						<input type="text" class="form-control input-airport destination txtautocomplete" id="destination" placeholder="Destination" name="destination" >
						<i class="fa fa-map-marker form-control-feedback right-1 right" aria-hidden="true"></i>
					</div>

					{{-- <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
						<input type="text" class="form-control has-feedback-left datepicker p-left-10 arrival" placeholder="Arrival" aria-describedby="inputSuccess2Status3">
						<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
					</div> --}}

					{{-- Rooms-element  --}}
					<div id="pax">
						{{-- Adult Button --}}
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-15-only form-group has-feedback">
							<div class="center">
								<div class="input-group">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-number noradius bg-color-gray" disabled="disabled" data-type="minus" data-field="person" data-name="adult">
											<span class="glyphicon glyphicon-minus"></span>
										</button>
									</span>
									<span class="form-control text-center nopadding-right">
										<span id="a_value">
											<input type="text" id="seat_count" name="person" class="width-15 adult nostyle input-number" value="2" min="1" max="10" disabled="disabled">
										</span>
										<span id="a_word" name="person">Person</span>
									</span>
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="person" data-name="adult">
											<span class="glyphicon glyphicon-plus"></span>
										</button>
									</span>
								</div>
							</div>
						</div>
						{{-- /Adult Button --}}
					</div>
					{{-- /Rooms-element  --}}
				</div>
				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
						<button type="button" id="btn_submit" class="btn btn-success btn-block">Submit</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
{{-- /Cab Serach --}}