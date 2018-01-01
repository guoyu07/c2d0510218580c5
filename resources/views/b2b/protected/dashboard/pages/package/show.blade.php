@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ commonAsset('datetimepicker/jquery.datetimepicker.min.css') }}"/>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="">
					<div class="col-md-9 col-sm-9 col-xs-12 nopadding">
						<h2>
							{{ $client->fullname }}
							<small>({{ $client->leadVendor->company_name }})</small>
						</h2>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
						<a href="{{ $client->createRouteUrl() }}" type="button" id="formSubmit" class="btn btn-success btn-block">Build New Package</a>
					</div>
				</div>
				<div class="x_content">
					<div class="col-md-5 col-sm-5 col-xs-12">
						<p>
							<i class="fa fa-phone"> :</i>
							<span>
								{{ isset($client->mobile) ? $client->mobile : '' }}
							</span>
						</p>
						<p>
							<i class="fa fa-envelope"> :</i>
							<span>
								{{ isset($client->email) ? $client->email : '' }}
							</span>
						</p>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<p>
							<label for=""><i class="fa fa-edit"> </i> Note : </label>
							<div class="scroll-bar" style="max-height: 163px; overflow: auto;">
								{{ isset($client->note) ? $client->note : '' }}
							</div>
						</p>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12 m-top-10">
						<p>
							<label for=""><i class="fa fa-calendar"> </i> Created At : </label>
							<span>
								{{ isset($client->created_at) ? $client->created_at : '' }}
							</span>
						</p>
						<p>
							<label for=""><i class="fa fa-calendar"> </i> Updated At : </label>
							<span>
								{{ isset($client->updated_at) ? $client->updated_at : '' }}
							</span>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Packages List</h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox1">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>PackageId</th>
								<th>Opening Date</th>
								<th>Updated Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@forelse ($packages as $package)
								<tr>
									<td>{{ $package->uid }}</td>
									<td>{{ $package->created_at }}</td>
									<td>{{ $package->updated_at }}</td>
									<td>{{ $package->status }}</td>
									<td>
										<a href="{{ route('openPackage', $package->token) }}" class="btn btn-success btn-xs btn-block">Open</a>
									</td>
								</tr>
							@empty
							@endforelse
						</tbody>
					</table>
					<div class="row">
						<span class="pull-right">
							{{ $packages->links() }}
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('js')

	{{-- Datatables --}}
	<script src="{{ commonAsset('dashboard/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/mydatatable.js') }}"></script>
	{{-- /Datatables --}}
@endsection


@section('scripts')
	<script>
		$(document).ready(function() {
			datatableWithSearch('#datatable');
		});
	</script>
@endsection
