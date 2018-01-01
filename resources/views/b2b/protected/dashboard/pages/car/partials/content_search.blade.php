{{-- Cab Serach --}}
<div class="col-md-3 col-md-3 col-xs-12">
	<div class="x_panel">
		<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left height-50vh">
			<div class="x_title">
				<h2><div class="text-center"><i class="fa fa-cab"></i> Car Search</div></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content m-top-10-only">
				<div class="form-group">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-15-only">
						<input type="text" class="form-control input-airport origin txtautocomplete" id="origin" placeholder="Origin" name="origin" data-lat="" data-long="">
						<i class="fa fa-map-marker form-control-feedback right-1 right" aria-hidden="true"></i>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-15-only">
						<input type="text" class="form-control input-airport destination txtautocomplete" id="destination" placeholder="Destination" name="destination" data-lat="" data-long="">
						<i class="fa fa-map-marker form-control-feedback right-1 right" aria-hidden="true"></i>
					</div>

					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
						<input id="start_date" type="text" class="form-control has-feedback-left datepicker p-left-10 start-date" placeholder="Start Date" aria-describedby="inputSuccess2Status3">
						<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
						<input id="end_date" type="text" class="form-control has-feedback-left datepicker p-left-10 end-date" placeholder="End Date" aria-describedby="inputSuccess2Status3">
						<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
					</div>

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