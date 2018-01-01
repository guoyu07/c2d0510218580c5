@extends('b2b.protected.dashboard.main')

@section('title', ' | Select Destination')


@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
@endsection

@section('content')
		<div class="row">
		{{-- Hotel Serach --}}
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
				<div class="row">	
					<div class="x_panel">
						<form id="search_form" method="post" action="{{ url('/new/destination') }}">
							<div class="x_title" >
								<div class="row">
									<div class="col-md-8 col-sm-8 col-xs-12">
										<h3><i class="fa fa-map-marker"></i> Select Destination</h3>
										@if ($destination != '')
											<div>
												<label for="">Your have search : </label>{{ $destination }}
											</div>
										@endif
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="x_content nopadding">
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" value="{{ csrf_token() }}" name="_token" hidden>
										<input type="text" value="{{ $route_id }}" name="route_id" hidden>
										<input type="text" class="form-control has-feedback location destination p-right-40" placeholder="Destination" name="destination" required>
										<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-top-30">
									<button type="submit" {{-- id="formSubmit"  --}} class="btn btn-success btn-block">Next</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		{{-- /Hotel Serach --}}
	</div>
	
@endsection


@section('js')
	<script src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
@endsection

@section('scripts')
	@include('b2b.protected.dashboard.pages.destination.partials.content_scripts')
@endsection
