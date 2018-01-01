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
								<th>Name</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>Opening Date</th>
								<th>Updated Date</th>
								<th>Package Link</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@foreach ($packages as $package)
								<tr>
									<td>{{ $package->uid }}</td>
									<td>{{ $package->client->fullname }}</td>
									<td>{{ $package->client->mobile }}</td>
									<td>{{ $package->client->email }}</td>
									<td>{{ $package->created_at }}</td>
									<td>{{ $package->updated_at }}</td>
									<td>
										@if (!is_null($package->package_url))
											<a href="{{ $package->package_url }}" class="btn-link" target="_blank">Open</a>
										@else
											--
										@endif
									</td>
									<td>{{ $package->status }}</td>
									<td>
										<a href="{{ route('openPackage', $package->token) }}" class="btn btn-success btn-xs btn-block">Open</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<div class="row">
						<span class="pull-right">
							{{ $packages->appends(request()->input())->links() }}
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
			datatableWithSearch('#datatable', {"order": [[ 5, "desc" ]]});
		});
	</script>
@endsection
