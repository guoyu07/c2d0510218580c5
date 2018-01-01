<table id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Client ID</th>
			<th>Full Name</th>
			<th>Mobile No.</th>
			<th>Email Id</th>
			<th>Opening Date</th>
			<th>Assign To</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
			@foreach ($clients as $client)
			<tr class="{{ $client->borderCss() }}">
				<td>{{ $client->uid }}</td>
				<td>{{ $client->fullname }}</td>
				<td>{{ $client->mobile }}</td>
				<td>{{ $client->email }}</td>
				<td>{{ $client->created_at }}</td>
				<td>{!! $client->assign_to !!}</td>
				<td class="{{ $client->statusCss() }}">{{ $client->statusToWord() }}</td>
				<td>
					<a href="{{ url('dashboard/enquiry/'.$client->id) }}" class="btn btn-success btn-xs" >Open</a>
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
<div class="col-md-12">
	<span class="pull-right">{{ $clients->links() }}</span>
</div>


@section('js')
	@parent
	<script src="{{ asset('js/mydatatable.js') }}"></script>
@endsection
@section('scripts')
	@parent
	<script>
		$(document).ready(function() {
			datatableWithSearch('#datatable', {"order": [[ 5, "desc" ]]});
		});
	</script>
@endsection