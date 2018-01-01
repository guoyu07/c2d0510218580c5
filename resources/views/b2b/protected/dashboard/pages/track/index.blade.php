@extends('b2b.protected.dashboard.main')

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Tracks <small>(Package Status)</small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Package Id</th>
								<th>Client Name</th>
								<th>Read Time</th>
								<th>Duration</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						@foreach($tracks->groupBy('package_id')->values() as $key => $trackData)
							<tr>
								<th scope="row">{{ $key+1 }} </th>
								<td>{{ $trackData->first()->package->uid }} </td>
								<td>{{ $trackData->first()->package->client->fullname }}</td>
								<td>{{ $trackData->first()->created_at }}</td>
								<td>{{ $trackData->first()->stay_time }}</td>
								<td>
									<a class="btn btn-success btn-xs">Open</a>
									<a class="accordion-toggle pull-right cursor-pointer"  data-toggle="collapse" data-target="#collapse_{{ $key }}"><i class="fa fa-chevron-up" onclick="$(this).toggleClass('fa-chevron-up fa-chevron-down')"></i></a>
									
								</td>
							</tr>
							<tr>
								<td colspan="6" class="nopadding noborder">
									<div id="collapse_{{ $key }}" class="collapse" aria-expanded="false" style="height: 0px;">
										<div class="x_panel" >
											<div class="x_content">
												<table class="table table-striped">
													<thead>
														<tr>
															<th>#</th>
															<th>Package Id</th>
															<th>Client Name</th>
															<th>Read Time</th>
															<th>Duration</th>
														</tr>
													</thead>
													<tbody>
													@foreach($trackData as $trackKey => $track)
														<tr>
															<th scope="row">{{$trackKey+1}}</th>
															<td>{{ $track->package->uid }}</td>
															<td>{{ $track->package->client->fullname }}</td>
															<td>{{ $track->created_at }}</td>
															<td>{{ $track->stay_time }}</td>
														</tr>
													@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<span class="pull-right">
								{{ $tracks->links() }}
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection