@extends('backend.protected.dashboard.main')


@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('dashboard/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-3 col-sm-3 col-xs-12">
			<a href="{{ url('dashboard/activities/create') }}" class="btn btn-success btn-block">Creat new activity</a>
		</div>
		<div class="col-md-4 col-sm-7 col-xs-12 text-center">
			<h3>Activities List</h3>
		</div>
		<div class="col-md-5 col-sm-8 col-xs-12 form-group pull-right top_search">
			<form action="{{ url('dashboard/activities/') }}" method="head">
				<div class="input-group">
					<input type="text" class="form-control location" name="s" placeholder="Enter Destination...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit">Go!</button>
					</span>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<table id="datatable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Activity ID</th>
								<th>Name</th>
								{{-- <th>Country</th> --}}
								{{-- <th>City</th> --}}
								<th>Currency</th>
								<th>Rank</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@include('backend.protected.dashboard.pages.activity.index_partials.all')
							{{-- @include('backend.protected.dashboard.pages.activity.index_partials.fgf') --}}
							{{-- @include('backend.protected.dashboard.pages.activity.index_partials.viator') --}}
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-12 pull-right text-right">
						@if (!is_null($activities))
							{{ $activities->appends(['s' => $request->s])->links() }}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	{{-- autocomplete --}}
	<script src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	{{-- autocomplete --}}

	{{-- Datatables --}}
	<script src="{{ commonAsset('dashboard/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	{{-- /Datatables --}}

@endsection

@section('scripts')
	@include('backend.protected.dashboard.pages.activity.index_partials._scripts')
@endsection