@extends('admin.protected.dashboard.main')
@section('content')
	<div class="row top_tiles m-top-50">
		@foreach ($plans as $plan)
			<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="tile-stats {{ $plan->id == 2 ? 'border-red-2px' : '' }}">
					<form action="{{ url('agent/credits_checkout') }}">
						<input type="text" name="plan" value="{{ $plan->id }}" hidden>
						<div class="height-150px font-size-30 vertical-parent">
							<div class="vertical-child">
								<i class="fa fa-file-pdf-o font-size-80 m-top-20"></i>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="m-top-20">{{ $plan->name }}</div>
								</div>
							</div>
						</div>
						<div class="height-100px font-size-30 vertical-parent">
							<div class="vertical-child">
								<div class="col-md-12 col-sm-12 col-xs-12">
									
								</div>
							</div>
						</div>
						<div class="height-50px font-size-30 vertical-parent">
							<div class="vertical-child">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="m-top-20">
										@if (!$plan->with_price)
										<input id="amount" name="amount" type="number" class="form-control" placeholder="Enter Price" required="required">
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="height-80px font-size-30 vertical-parent">
							<div class="vertical-child">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="m-top-20">
										<button type="submit" class="btn btn-success btn-block">Select</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		@endforeach
	</div>
@endsection