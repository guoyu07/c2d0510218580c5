<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<input type="text" class="form-control width-100-p title" placeholder="Activity Title..." value="`+name+`" />
	</div>
</div>
<div class="row m-top-10"></div>
<div class="row">
	<div class="col-md-7 col-sm-7 col-xs-12">
		<label for="">Description : </label>
		<textarea class="form-control width-100-p min-height-125px description">`+description+`</textarea>
		
		<label for="">Inclusion : </label>
		<textarea class="form-control width-100-p min-height-125px inclusion">`+inclusion+`</textarea>

		<label for="">Exclusion : </label>
		<textarea class="form-control width-100-p min-height-125px exclusion">`+exclusion+`</textarea>
	</div>
	<div class="col-md-5 col-sm-5 col-xs-12">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<label for="">Pick-Up Time</label>
				<input type="text" class="form-control pick_up" data-inputmask="'mask': '99:99'" placeholder="HH:MM" value="`+pick_up+`"/>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<label for="">Duration</label>
				<input type="text" class="form-control duration" data-inputmask="'mask': '99:99'" placeholder="HH:MM" value="`+duration+`"/>
			</div>
		</div>
		<div class="row m-top-10"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<form id="uploadform" class="uploadform dropzone no-margin nopadding dz-clickable min-max-height-380px bg-color-gray" data-path="" data-host="">	
					{{ csrf_field() }}
					<div class="dz-default dz-message">
						<div class="row">
							<div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2">
								<div class="height-100px vertical-parent">
									<div class="vertical-child">
										Drop activity image here
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>