@extends('admin.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-3 col-sm-3 col-xs-12">
			<a href="{{url('dashboard/enquiry')}}" class="btn btn-success btn-block">
				<i class="fa fa-arrow-left"></i> Back To All Enquiry
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-sm-6 col-md-offset-2 col-xs-12">
			<div class="form-style-8 m-top-20" >
				<h2>Detail Plase</h2>
				<form method="post" action="{{ url('dashboard/enquiry/'.(isset($enquiry->id) ? $enquiry->id : '')) }}">
					{{ isset($enquiry->id) ? method_field('PUT') : '' }}
					{{ csrf_field() }}
					<select name="vendor">
						<option value="">Lead From(Vendor)?</option>
						@foreach ($auth->leadVendors as $leadVendor)
							<option value="{{ $leadVendor->id }}" name="vendor" {{ $leadVendor->id == (isset($enquiry->lead_vendor_id) ? $enquiry->lead_vendor_id : old('lead_vendor_id')) ? "selected" : ""}}>{{ $leadVendor->company_name }}</option>
						@endforeach
					</select>

					<select name="agent">
						<option value="">Assign To</option>
						@foreach ($auth->users as $agent)
							<option value="{{ $agent->id }}" name="agent" {{ $agent->id == (isset($enquiry->user_id) ? $enquiry->user_id : old('user_id')) ? "selected" : ""}} >
								{{ $agent->assign_to }}
							</option>
						@endforeach
					</select>

					<input type="text" name="fullname" value="{{ isset($enquiry->fullname) ? $enquiry->fullname : old('fullname') }}" placeholder="Full Name" />
					<input type="text" name="mobile" value="{{ isset($enquiry->mobile) ? $enquiry->mobile : old('mobile') }}" placeholder="Mobile" maxlength="10"/>
					<input type="email" name="email" value="{{ isset($enquiry->email) ? $enquiry->email : old('email') }}" placeholder="Email" />
					<textarea name="note" placeholder="Message" onkeyup="adjust_textarea(this)">{{ isset($enquiry->note) ? $enquiry->note : old('note') }}</textarea>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="submit" class="btn btn-success btn-block radius-0" value="Let's Go..." />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
