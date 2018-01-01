<div class="x_panel">
	<div class="x_title">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<h2>Total Action on Lead</h2>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<select name="" id="" class="m-top-5 width-120">
					@for($m = 1 ; $m <= 12; $m++)
						<option value="{{ $m }}">{{ date("F",strtotime(date("Y")."-".$m."-01")) }}</option>
					@endfor
				</select>
				<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
					<li></li>
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
			</div>
			<div id="lineChartLabels" hidden>["January", "February", "March", "April", "May", "June", "July"]</div>
			<div id="lineChartActive" hidden>[31, 74, 6, 39, 20, 85, 99]</div>
			<div id="lineChartInactive" hidden>[82, 23, 66, 9, 99, 4, 2]</div>
			<div id="lineChartConfirmed" hidden>[48, 23, 33, 9, 29, 4, 2]</div>
		</div>

		<div class="clearfix"></div>
	</div>
	<div class="x_content height-355px ">
		<canvas id="lineChart" class="m-top-30"></canvas>
	</div>
</div>