<div id="currencies" class="x_panel tile">
	<div class="x_title">
		<h2>Currency Exchange<small>(INR)</small></h2>
		<ul class="nav navbar-right panel_toolbox panel_toolbox1">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content" style="height:348px;">
		{{-- {{ pre_echo($currencyData) }} --}}
		<div class="widget_summary">
			<div class="w_left w_25">
				<span>INR Default</span>
			</div>
			<div class="w_center w_55">
				<div class="progress">
					<div class="progress-bar bg-green" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%;">
					</div>
				</div>
			</div>
			<div class="w_right w_20">
				<span>1</span>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="widget_summary">
			<div class="w_left w_25">
				<span>USD</span>
			</div>
			<div class="w_center w_55">
				<div class="progress">
					<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->USD) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->USD) }}%;">
					</div>
				</div>
			</div>
			<div class="w_right w_20">
				<span>{{ roundUp(ifset($currencyData->currencies->USD)) }}</span>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="widget_summary">
			<div class="w_left w_25">
				<span>SGD</span>
			</div>
			<div class="w_center w_55">
				<div class="progress">
					<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->SGD) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->SGD) }}%;">
					</div>
				</div>
			</div>
			<div class="w_right w_20">
				<span>{{ roundUp(ifset($currencyData->currencies->SGD)) }}</span>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="widget_summary">
			<div class="w_left w_25">
				<span>EUR</span>
			</div>
			<div class="w_center w_55">
				<div class="progress">
					<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->EUR) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->EUR) }}%;">
					</div>
				</div>
			</div>
			<div class="w_right w_20">
				<span>{{ roundUp(ifset($currencyData->currencies->EUR)) }}</span>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="widget_summary">
			<div class="w_left w_25">
				<span>AED</span>
			</div>
			<div class="w_center w_55">
				<div class="progress">
					<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->AED) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->AED) }}%;">
					</div>
				</div>
			</div>
			<div class="w_right w_20">
				<span>{{ roundUp(ifset($currencyData->currencies->AED)) }}</span>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="widget_summary">
			<div class="w_left w_25">
				<span>IDR</span>
			</div>
			<div class="w_center w_55">
				<div class="progress">
					<div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{ ifset($currencyData->currencies->IDR) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ifset($currencyData->currencies->IDR) }}%;">
					</div>
				</div>
			</div>
			<div class="w_right w_20">
				<span><small>{{ ifset($currencyData->currencies->IDR) }}</small></span>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>