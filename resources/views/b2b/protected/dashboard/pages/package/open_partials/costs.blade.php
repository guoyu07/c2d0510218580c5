<div class="x_panel">
	<div class="x_title">
		<h2>
			Grand Total
		</h2>
		<ul class="nav navbar-right panel_toolbox panel_toolbox1">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		{{-- Grand Total Left Side --}}
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12 font-size-15">
				<div class="visa checkbox nomargin">
					<label class="nopadding width-100-p">
						<div class="row">
							<div class="col-md-2 col-sm-2 col-xs-1">
								<input id="visaCostCheckbox" type="checkbox" class="flat" data-type="visa" {{isset($package->cost->is_visa) && $package->cost->is_visa ? 'checked' : ''}}>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-10">
								<b>Visa Applicable : </b>
							</div>
						</div>
					</label>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="visaCost" data-yes="0" data-no="0" class="inputCalc form-control has-feedback-left p-left-10" placeholder="Visa Cost" aria-describedby="inputSuccess2Status3" name="TotalHotelsCost" value="{{ isset($package->cost->visa_cost) ? $package->cost->visa_cost : 0 }}">
				<i class="fa fa-home form-control-feedback right" aria-hidden="true"></i>
			</div>
		</div>
		{{-- Hotel Cost --}}
		<div class="row m-top-10">
			<div class="col-md-6 col-sm-6 col-xs-12 font-size-15 m-top-5">
				<label for=""> Net Cost : </label>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="netCost" class="inputCalc form-control has-feedback-left p-left-10" placeholder="want to enter Manually" aria-describedby="inputSuccess2Status3" name="TotalHotelsCost" value="{{ isset($package->cost->net_cost) ? $package->cost->net_cost : 0 }}">
				<i class="fa fa-home form-control-feedback right" aria-hidden="true"></i>
			</div>
		</div>

		<div class="row m-top-10">
			<div class="col-md-6 col-sm-6 col-xs-12 font-size-15 m-top-5">
				<label for=""> Profit/Margin Cost : </label>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="profitCost" class="inputCalc form-control has-feedback-left p-left-10" placeholder="want to enter Manually" aria-describedby="inputSuccess2Status3" name="TotalHotelsCost" value="{{ isset($package->cost->margin) ? $package->cost->margin : 0 }}">
				<i class="fa fa-home form-control-feedback right" aria-hidden="true"></i>
			</div>
		</div>

		<div class="row m-top-10">
			<div class="col-md-6 col-sm-6 col-xs-12 font-size-15 m-top-5">
				<h2><label for=""> Total Cost : </label></h2>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="text-right">
					<h2>
						<i class="fa fa-rupee"></i> 
						<span id="totalCost" data-ischanged="0" data-error="0">
							{{ isset($package->cost->total_cost) && $package->cost->total_cost ? $package->cost->total_cost : 0  }}.00
						</span>
					</h2>
				</div>
			</div>
		</div>

		<div class="row m-top-20">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<button type="button" id="btn_save_cost" class="btn btn-success btn-block">Save Cost</button>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				{{-- <button id="run_pdf" class="btn btn-primary btn-block" target="_blank">Generate PDF</button>
				<a id="btn_pdf" href="{{ newRedirectUrl(urlPdfPacakge($package->id)) }}" class="btn btn-primary btn-block hide" target="_blank"></a> --}}
			</div>
		</div>
		{{-- /Grand Total Left Side --}}
	</div>
</div>