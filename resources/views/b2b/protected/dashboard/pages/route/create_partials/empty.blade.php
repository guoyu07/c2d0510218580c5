<div id="destination1" class="col-md-12 col-sm-12 col-xs-12 form-group-self destinationList no-rid" data-destination="1" data-rid="" data-order="">
	<div class="col-md-3 col-sm-3 col-xs-12">
		<div class="row">
			<div class="col-md-2 col-sm-2 col-xs-1">
				<i class="fa fa-arrows font-size-20 m-top-5"></i>
			</div>
			<div class="col-md-10 col-sm-10 col-xs-11">
				<select class="form-control nopadding p-left-10 mode inctv" data-parsley-type="value" required="">
					<option value="" selected>Select Mode</option>
					{!! $indication->htmlOptions('route_mode') !!}
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-8 col-sm-8 col-xs-12">
		<div class="row location-input-div"></div>
	</div>
	<div class="col-md-1 col-sm-1 col-xs-12 text-center">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6 text-center">
				<a class="rmv-destlist cursor-pointer">
					<i class="fa fa-times-circle font-size-30 m-top-2"></i>
				</a>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6 text-center">
				<a class="btn-add-route green cursor-pointer">
					<i class="fa fa-plus-square font-size-30 m-top-2"></i>
				</a>
			</div>
		</div>
	</div>
</div>