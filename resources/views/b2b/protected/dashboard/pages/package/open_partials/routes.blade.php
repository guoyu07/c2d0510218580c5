<div class="x_panel">
	<div class="x_title">
		<div class="row">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<h1>Routes</h1>
			</div>
			{{-- <div class="col-md-1 col-sm-1 col-xs-12 pull-right m-top-10">
				<ul class="nav navbar-right panel_toolbox panel_toolbox1">
					<li>
						<a class="collapse-link">
							<i class="fa fa-chevron-up font-size-30"></i>
						</a>
					</li>
				</ul>
			</div> --}}
			<div class="col-md-4 col-sm-4 col-xs-12 m-top-10">
				<a href="{{ $package->createRouteUrl() }}" class="btn btn-success btn-block">Modify Route</a>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">

		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					{{-- <th>id</th> --}}
					<th>Mode</th>
					<th>Start</th>
					<th>End</th>
					<th>Origin</th>
					<th>Destination</th>
					<th>Pickup</th>
					<th>Drop</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@if($package->routes->count())
					@foreach($package->routes as $routeKey => $route)
						<?php 
							$dateFormat = $route->checkMode('flight') ? 'd-M-Y H:i' : 'd-M-Y';
						?>
						<tr class="{{$route->status == 'active' ? 'font-dark-red' : ''}}">
							<th scope="row">{{ $routeKey+1 }}</th>
							{{-- <td>{{$route->id}}</td> --}}
							<td>{{proper($route->mode)}}</td>
							<td>{{$route->start_datetime->format($dateFormat)}}</td>
							<td>{{$route->status == 'active' ? '?' : $route->end_datetime->format($dateFormat)}}</td>
							<td>{{$route->origin == '' ? '-' : proper($route->origin)}}</td>
							<td>{{proper($route->destination)}}</td>
							<td>{{$route->pick_up == '' ? '-' : proper($route->pick_up)}}</td>
							<td>{{$route->drop_off == '' ? '-' : proper($route->drop_off)}}</td>
							<th>{{proper($route->status)}}</th>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>

	</div>
</div>