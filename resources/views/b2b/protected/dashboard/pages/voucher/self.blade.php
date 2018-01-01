@extends('b2b.protected.dashboard.main')

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Create Voucher</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form class="form-horizontal form-label-left input_mask">
						
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="First Name">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess3" placeholder="Last Name">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess3" placeholder="File No.">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess5" placeholder="Phone">
						<span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control has-feedback-right" id="inputSuccess4" placeholder="No of Adult">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control has-feedback-right" id="inputSuccess4" placeholder="No of Child">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess5" placeholder="Emergency Phone">
						<span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
					</div>
					
					<div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control has-feedback-right" id="inputSuccess4" placeholder="Email">
						<span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Hotel Detail</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="form-horizontal form-label-left input_mask">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label for="">Hotel 1:</label>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control" id="inputSuccess2" placeholder="Hotel Name">
								<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control" id="inputSuccess2" placeholder="Room Type">
								<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control" id="inputSuccess2" placeholder="No Of Rooms">
								<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control" id="inputSuccess2" placeholder="Meal">
								<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" style="margin: 0px -2px 0px 0px; height: 120px; width: 485px;" placeholder="Cancellation policy"></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<button class="btn btn-success">Add Hotel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Flight Detail</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="form-horizontal form-label-left input_mask">
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Origin (DEL)">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Destination (SIN)">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Departure Time">
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Arrival Time">
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Flight No.">
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<button class="btn btn-success">Add Flight</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Activity Detail</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="form-horizontal form-label-left input_mask">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Activity Name">
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Destination (SIN)">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Departure Time">
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Arrival Time">
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="Flight No.">
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<button class="btn btn-success">Add Activity</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

