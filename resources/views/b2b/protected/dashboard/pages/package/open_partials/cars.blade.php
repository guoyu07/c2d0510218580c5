@if ($package->cars->count())
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<h1>Cars List</h1>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 m-top-10">
					<ul class="nav navbar-right panel_toolbox panel_toolbox1">
						<li><a class="collapse-link"><i class="fa fa-chevron-up font-size-30"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			@foreach ($package->cars as $car)
				@if ($car->selected_car_vendor == 'ss')
					@include($viewPath.'.open_partials.car_partials.ss')
				@endif
			@endforeach
		</div>
	</div>
</div>
@endif