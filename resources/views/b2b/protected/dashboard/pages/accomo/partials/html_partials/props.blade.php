<div class="row padding-10 border-gray m-top-5">
	<div class="col-md-12 col-sm-12 col-xs-12 prop-container">
		<div class="row">
			{{-- prop Type Image Div  --}}
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row height-120px">
					<img src="`+propImage+`" alt="" height="100%" width="100%">
				</div>
			</div>
			{{-- /prop Type Image Div  --}}

			{{-- prop type main Container --}}
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5">
						<div class="font-size-20">`+propType+`</div>
					</div>
				</div>
				<div class="row">
					<div class="m-top-50"></div>
				</div>
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-4">
						<label>No of Rooms : </label>
						<select class="no-of-rooms">
							<option value="">Rooms</option>
							`+roomOptions+`
						</select>
						{{-- @include($viewPath.'.partials.html_partials.pick_drop') --}}

					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 pull-right">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<button class="btn btn-block `+btnClass+` btn-book-prop"
									data-id="`+propId+`"
									data-papid="`+papId+`" {{-- package_accom.._pro..Id --}}
									data-vdr="`+propVdr+`" 
									>`+btnName+`</button>
							</div>
						</div>
					</div>
				</div>
					{{-- `+((mode == 'hotel') ? '
					@include($viewPath.'.partials.html_partials.meal')
					' : '')+` --}}
			</div>
		</div>
	</div>
</div>