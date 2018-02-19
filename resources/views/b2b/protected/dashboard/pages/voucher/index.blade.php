@extends('b2b.protected.dashboard.main')

@section('title', ' | voucher Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="col-md-3 col-sm-3 col-xs-3">
						<h2>Vouchers</h2>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-8 text-right">
						<label >Create Voucher for : </label>
						<a href="{{ route('vouchers.create.activity') }}" class="btn btn-success">Activity</a>
						<a href="{{ route('vouchers.create.accommodation') }}" class="btn btn-success">Accommodation</a>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-1">
						<ul class="nav navbar-right panel_toolbox panel_toolbox1">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Id</th>
								<th>Type</th>
								<th>Name</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>Created Date</th>
								<th>Updated Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@foreach ($vouchers as $voucher)
								<tr>
									<td>{{ $voucher->uid }}</td>
									<td>{{ $voucher->type }}</td>
									<td>{{ $voucher->client->fullname }}</td>
									<td>{{ $voucher->client->mobile }}</td>
									<td>{{ $voucher->client->email }}</td>
									<td>{{ $voucher->created_at }}</td>
									<td>{{ $voucher->updated_at }}</td>
									<td>{{ $voucher->status }}</td>
									<td>
										<a href="{{ $voucher->voucher_url }}" class="btn btn-success btn-xs btn-block">Open</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<div class="row">
						<span class="pull-right">
							{{ $vouchers->appends(request()->input())->links() }}
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
