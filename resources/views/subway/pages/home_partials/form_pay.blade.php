<form id="form_pay_now" action="{{ route('payPackage', [$token]) }}" data-parsley-validate="" method="post" class="form-horizontal form-label-left white" novalidate="">
	<input type="hidden" name="back" value="{{ Request::fullUrl() }}">
	{{ csrf_field() }}
	<div class="form-group">
		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Name <span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" name="name" required="required" class="form-control col-md-7 col-xs-12" value="{{ $package->client->fullname }}">
			<b><span class="red" data-error="name"></span></b>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobile">Mobile <span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" name="mobile" required="required" maxlength="10" class="form-control col-md-7 col-xs-12">
			<b><span class="red" data-error="mobile"></span></b>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">Email <span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" name="email" required="required" class="form-control col-md-7 col-xs-12">
			<b><span class="red" data-error="email"></span></b>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="date">Date of Departure <span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" name="date" required="required" class="form-control col-md-7 col-xs-12 datepicker noradius" readonly>
			<b><span class="red" data-error="date"></span></b>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="pax">Total Pax <span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" name="pax" required="required" class="form-control col-md-7 col-xs-12">
			<b><span class="red" data-error="pax"></span></b>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="amount">Amount <span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" name="amount" required="required" class="form-control col-md-7 col-xs-12">
			<b><span class="red" data-error="amount"></span></b>
			<div>
				<span>Pay U Money Charge (2.9%) : </span>
				<i class="fa fa-rupee"></i> 
				<b id="payu_charge">0</b>
				<span> /-</span>
			</div>
		</div>
	</div>

 	<div class="down-div">
		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-1">
				<button type="button" class="btn btn-default btn-pay">Book Now</button>
			</div>
		</div>
 	</div>
</form>