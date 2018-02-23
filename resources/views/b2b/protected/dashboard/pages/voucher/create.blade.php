@extends('b2b.protected.dashboard.main')


@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('content')
<div class="row">
	{{-- @include('b2b.protected.dashboard.pages.voucher._partials.client') --}}
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Client Info</h2>
				<a href="{{ route('vouchers.index') }}" class="btn btn-success pull-right">Back to list</a>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<!-- <div class="col-md-3 col-sm-3 col-xs-3">
					<label>ID : <span class="show-client-id"></span></label>
				</div> -->
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>Name : <span class="show-client-name">{{ $isCreate ? '' : $data->client->fullname }}</span></label>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>Mobile : <span class="show-client-mobile" data-token="{{ $isCreate ? '' : $data->client->token }}">
						{{ $isCreate ? '' : $data->client->mobile }}
					</span></label>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>Email : <span class="show-client-email">
						{{ $isCreate ? '' : $data->client->email }}
					</span></label>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row main-service-box">
	{{-- @include('b2b.protected.dashboard.pages.voucher._partials.accommodation') --}}
</div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			@if($isCreate)
				<div class="col-md-2 col-sm-2 col-xs-12">
					{{-- <button class="btn btn-success btn-block btn-save">Finish</button> --}}
					<a href="" class="btn btn-dark btn-finish" disabled>Finish</a>
				</div>
			@endif
			<!-- <div class="col-md-2 col-sm-2 col-xs-12">
				<button class="btn btn-default btn-block">Cancel</button>
			</div> -->

			{{-- <div class="col-md-2 col-sm-2 col-xs-12 pull-right">
				<button class="btn btn-primary btn-activity btn-block">Add Activity</button>
			</div> --}}
			<div class="col-md-2 col-sm-2 col-xs-12 pull-right">
				<button class="btn btn-primary btn-accommodation">Add Accommodation</button>
			</div>
		</div>
	</div>
</div>

<div class="hide">
	@include('b2b.protected.dashboard.pages.voucher._partials.client_input')
	@include('b2b.protected.dashboard.pages.voucher._partials.accommodation_input')
	@include('b2b.protected.dashboard.pages.voucher._partials.activity_input')
</div>

@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

@endsection

@section('scripts')
	@include('b2b.protected.dashboard.pages.voucher._partials._scripts')
@endsection 
