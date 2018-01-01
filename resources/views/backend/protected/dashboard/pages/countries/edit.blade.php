@extends('backend.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-8 col-sm-6 col-xs-12 col-md-offset-2">
			<div class="form-style-8 m-top-50">
				<h2 class="font-white width-100-p">Edit County</h2>
				<form method="POST" action="{{ url('dashboard/manage/location/country/'.$country->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="row">
						<div class="col-md-8 col-sm-8 col-xs-8">
							<input type="text" placeholder="Country" class="{{ $errors->has('country') ? 'border-bottom-red' : '' }}" name="country" value="{{ $country->country }}" required autofocus />
							@if ($errors->has('country'))
								<span class="help-block red">
									<strong>{{ $errors->first('country') }}</strong>
								</span>
							@endif
						</div>

						<div class="col-md-4 col-sm-4 col-xs-4">
							<input type="text" placeholder="Last Name" name="country_code" class="{{ $errors->has('country_code') ? 'border-bottom-red' : '' }}" value="{{ $country->country_code }}" required autofocus />
							@if ($errors->has('country_code'))
								<span class="help-block red">
									<strong>{{ $errors->first('country_code') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="row padding-tb-10">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<button type="submit" class="btn btn-success btn-block">
								Save
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('js')
	{{-- Custom Js  --}}
	<script src="{{ asset('js/custom-file-input.js') }}"></script>
@endsection