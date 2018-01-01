@if ($package->activityRoutes->count())
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<h1>Activities List</h1>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 m-top-10">
					<a href="{{ route('activities',[$package->token]) }}" class="btn btn-success btn-block">Modify All Activities</a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			@foreach ($package->activityRoutes as $activityRoutes)
				<?php
					$location = $activityRoutes->destination_detail;
					$selectedActivities = $activityRoutes->activities();
				?>
				@if ($selectedActivities->count())
				<div class="row">
					<div class="x_panel">
						<div class="x_title">
							<div class="col-md-4 col-sm-4 col-xs-12">
								<h2><b>{{ $location->echo_location }}</b></h2>
							</div>
							<div class="col-md-5 col-sm-5 col-xs-12">
								<h2 class="pull-right">
									({{ $activityRoutes->start_datetime->format('d-M-Y') }}
										To
									{{ $activityRoutes->end_datetime->format('d-M-Y')}})
								</h2>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="col-md-10 col-sm-10 col-xs-10">
									<a href="{{ route('activities',[$package->token]) }}?{{ http_build_query(['only' => [$activityRoutes->token]]) }}" class="btn btn-success pull-right">Modify</a>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="row">
								<ul class="list list-unstyled">
									@foreach ($selectedActivities as $activity)
										@include($viewPath.'.open_partials.activities_partials.index')
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
				@endif
			@endforeach
		</div>
	</div>
</div>
@endif
