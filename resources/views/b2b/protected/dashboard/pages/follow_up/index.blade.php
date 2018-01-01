@extends('b2b.protected.dashboard.main')

@section('css')
	<link href="{{ commonAsset('dashboard/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Follow Ups</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Package Id</th>
								<th>Full Name</th>
								<th>Date And Time</th>
								<th>Note</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							@foreach ($follow_ups as $follow_up)
								@if (!is_null($follow_up->package))
									<tr>
										<td>{{ $follow_up->package->uid }}</td>
										<td>{{ $follow_up->package->client->fullname }}</td>
										<td>{{ $follow_up->datetime }}</td>
										<td>{{ sub_string($follow_up->note) }}</td>
										<td>
											<div class="row">
												<div class="col-md-6 col-sm-6 col-xs-6 p-right-5">
													<a href="{{ route('openPackage', $follow_up->package->token) }}" class="btn btn-success btn-xs btn-block">Action</a>
												</div>
											</div>
										</td>
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="row">
					<span class="pull-right">
						{{ $follow_ups->links() }}
					</span>
				</div>
			</div>
		</div>
	</div>
@endsection

{{-- datatable --}}
@section('js')
	<script src="{{ commonAsset('dashboard/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/mydatatable.js') }}"></script>
@endsection

@section('scripts')
	<script>
		datatableWithSearch('#datatable', {"order": [[ 2, "asc" ]]});
	</script>
@endsection
{{-- /datatable --}}
