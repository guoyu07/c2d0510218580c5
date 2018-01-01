@extends('b2b.protected.dashboard.main')

@section('css')
		{{-- Datatables --}}
		<link href="{{ commonAsset('dashboard/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Client List</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Client ID</th>
								<th>Full Name</th>
								<th>Mobile No.</th>
								<th>Email Id</th>
								<th>Opening Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@foreach ($clients as $client)
								<tr>
									<a href="">
										
									<td>{{ $client->uid }}</td>
									<td>{{ $client->fullname }}</td>
									<td>{{ $client->mobile }}</td>
									<td>{{ $client->email }}</td>
									<td>{{ $client->created_at }}</td>
									<td>{{ $client->status }}</td>
									<td>
										<a href="{{ $client->openUrl() }}" class="btn btn-success btn-xs btn-block">Open</a>
									</td>
									</a>
								</tr>
							@endforeach
						</tbody>
					</table>
					<div class="row">
						<span class="pull-right">
							{{ $clients->links() }}
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
@endsection

@section('scripts')
	<script>
		$(document).ready(function() {
			datatableWithSearch('#datatable');
		});
	</script>
@endsection