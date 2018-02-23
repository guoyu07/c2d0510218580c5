@extends('b2b.protected.dashboard.main')

@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Client Info</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>ID : {{ $data->uid }}</label>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>Name : {{ $data->client->fullname }}</label>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>Mobile : {{ $data->client->mobile }}</label>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>Email : {{ $data->client->email }}</label>
				</div>
			</div>
		</div>
	</div>
	@foreach($data->voucherServices as $voucherService)
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="col-md-5 col-sm-5 col-xs-5">
						<h2>{{ $voucherService->type }}</h2>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-7">
						<label class="pull-right">Confirmation No: {{ array_get($voucherService->data, 'confirmation_no', '?') }}</label>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h2>{{ array_get($voucherService->data, 'name') }}</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							{{ $voucherService->check_in->format('d/M/Y l') }}
							- {{ $voucherService->check_out->format('d/M/Y l') }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label>Property Type : {{ proper(array_get($voucherService->data, 'prop_type')) }}</label>
						</div>
						@foreach($voucherService->guests as $key => $guest)
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label>Room {{ $key+1 }} : <i class="fa fa-user"></i> {{ str_plural('Adult', array_get($guest, 'adults', 2)) }} {{ array_get($guest, 'adults', 2) }}</label>
							</div>
						@endforeach
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
							<a href="{{ $voucherService->voucher_url }}" class="btn btn-success" target="_blank">Get Voucher</a>
							<button class="btn btn-primary btn-primary btn-service-edit" data-vstoken="{{$voucherService->token}}">Edit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
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