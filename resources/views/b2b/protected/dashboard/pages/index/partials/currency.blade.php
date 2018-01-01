<div id="currencies" class="x_panel tile">
	<div class="x_title">
		<h2>Currency Exchange<small>(INR)</small></h2>
		<ul class="nav navbar-right panel_toolbox panel_toolbox1">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		</ul>
		<div class="clearfix"></div>
	</div>

	<div class="x_content" style="height:333px;" >
		<div v-if="isGot" v-cloak>
			<div class="widget_summary" v-for="rate in rates">
				<div class="w_left w_25">
					<span v-text="rate.Name"></span>
				</div>
				<div class="w_center w_55">
					<div class="progress">
						<div class="progress-bar bg-green" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" :style="'width: '+rate.Rate+'%;'">
						</div>
					</div>
				</div>
				<div class="w_right w_20">
					<span class="font-size-15" v-text="rate.Rate"></span>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div v-else class="text-center">
			<i class="fa fa-refresh fa-spin fa-5x fa-fw m-top-100"></i>
		</div>
	</div>
</div>