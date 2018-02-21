<div class="temp-activity-service-child-box">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" class="service-type" value="activity" hidden="">
					<input type="text" class="form-control location" placeholder="Destination">
					<span class="fa fa-map-marker form-control-feedback right" aria-hidden="true"></span>
				</div>
				
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" class="form-control activity-name" placeholder="Activity Name">
					<span class="fa fa-building-o form-control-feedback right" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<label>Unable to find activity? to add activity <a href="{{ route('inventories.activity.store') }}" class="btn btn-success btn-xs btn-create-activity" data-href="{{ route('inventories.activity.store') }}" target="_blank">click here</a></label>
				</div>

				<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
					<input type="text" class="form-control check-in datepicker p-left-10" placeholder="Activity Date" aria-describedby="inputSuccess2Status3">
					<span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
				</div>

				<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
					<input type="text" class="form-control confirmation-no" placeholder="Confirmation No. (optional)">
					<span class="fa fa-barcode form-control-feedback right" aria-hidden="true"></span>
				</div>
				 
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<div class="row">
						<div class="col-md-3 col-sm-3 col-xs-3">
							<label class="m-top-2">No of Adult :</label>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2">
							<input type="text" class="form-control nopadding text-center" placeholder="Adults" value="2">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<textarea id="message" required="required" class="form-control cancellation_policy col-md-12 col-sm-12 col-xs-12" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" style="margin: 0px -2px 0px 0px; height: 120px;" placeholder="Cancellation policy"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<textarea id="message" required="required" class="form-control remark col-md-12 col-sm-12 col-xs-12" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" style="margin: 0px -2px 0px 0px; height: 120px;" placeholder="Remark"></textarea>
				</div>
			</div>
		</div>
	</div>
</div>
