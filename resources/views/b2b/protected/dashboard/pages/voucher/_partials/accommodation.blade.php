<div class="col-md-12 col-sm-12 col-xs-12 service-child-box" data-ukey="`+_.get(windata, 'ukey_count')+`" data-type="accommodation">
	<div class="x_panel">
		<div class="x_title">
			<h2>Accommodation</h2>
			<ul class="nav navbar-right panel_toolbox panel_toolbox1">
				<li><a class="collapse-link m-right-10"><i class="fa fa-chevron-up"></i></a></li>
				<li><a class="new-close-link"><i class="fa fa-close"></i></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="form-horizontal form-label-left input_mask">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control location" placeholder="Destination">
								<span class="fa fa-map-marker form-control-feedback right" aria-hidden="true"></span>
							</div>
							
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control check-in datepicker p-left-10" placeholder="Check-in" aria-describedby="inputSuccess2Status3">
								<span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control check-out datepicker p-left-10" placeholder="Check-out" aria-describedby="inputSuccess2Status3">
								<span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<button class="btn-popup-room-guest form-control text-right font-gray" type="button">
									<span class="pull-left font-gray">Guests : </span>
									<span class="guests-word font-gray">Adults, Kid</span>
									<span class="caret"></span>
								</button>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control confirmation-no" placeholder="Confirmation No. (optional)">
								<span class="fa fa-barcode form-control-feedback right" aria-hidden="true"></span>
							</div>

							 
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control accommo-name" placeholder="Hotel Name">
								<span class="fa fa-building-o form-control-feedback right" aria-hidden="true"></span>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control prop-type" placeholder="Room Type">
								<span class="fa fa-bookmark-o form-control-feedback right" aria-hidden="true"></span>
							</div>
							<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="nomargin meal room_only"> Room Only</label>
							<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="nomargin meal breakfast"> Breakfast</label>
							<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="nomargin meal lunch"> Lunch</label>
							<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="nomargin meal dinner"> Dinner</label>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<textarea id="message" required="required" class="form-control cancellation_policy" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" style="margin: 0px -2px 0px 0px; height: 120px; width: 485px;" placeholder="Cancellation policy"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<textarea id="message" required="required" class="form-control remark" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" style="margin: 0px -2px 0px 0px; height: 120px; width: 485px;" placeholder="Remark"></textarea>
							</div>
						</div>
					</div>
				</div>
				{{-- <div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<button class="btn btn-success btn-save col-md-2 col-sm-2 col-xs-2">Save</button>
						<a href="{{ url('dashboard/vouchers/') }}" class="btn btn-default col-md-2 col-sm-2 col-xs-2">Cancel</a>
					</div>
				</div> --}}
			</div>
		</div>
	</div>
</div>