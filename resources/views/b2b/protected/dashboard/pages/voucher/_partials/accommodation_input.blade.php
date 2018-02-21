<div class="temp-service-child-box">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" class="service-type" value="accommodation" hidden="">
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

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
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
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-2 m-top-5">
							<label class="m-top-2">Rooms :</label>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 m-top-5 room-box">
							<div class="row">
								<div class="col-md-9 col-sm-9 col-xs-9 nopadding p-right-5">
									<input type="text" class="form-control adults height-25 p-2-5" placeholder="Adults" value="2">
								</div>
								<!-- <div class="col-md-3 col-sm-3 col-xs-3 nopadding m-top-2">
									<a class="cursor-pointer remove-room"><i class="fa fa-times"></i></a>
								</div> -->
							</div>
						</div>
						<div class="col-md-1 col-sm-1 col-xs-1 box-add-room m-top-5">
							<button class="btn btn-success btn-xs btn-add-room m-top-2"><i class="fa fa-plus"></i></button>
						</div>
					</div>
				</div>
				<label class="col-md-3 col-sm-3 col-xs-12">Meal : </label>
				<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="nomargin meal breakfast"> Breakfast</label>
				<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="nomargin meal lunch"> Lunch</label>
				<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="nomargin meal dinner"> Dinner</label>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<label for=""><small>Note : if in meal option there is nothing selected then it will be <b class="red">Room Only</b></small></label>
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
