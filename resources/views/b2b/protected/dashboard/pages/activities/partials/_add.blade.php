<li class="min-height-110px activity-container added-own li_'+code+'">
	<div class="row">
		<div class="x_panel glowing-border border-blue-1px isSelectedBorder" data-vendor="own">
			<div class="col-md-10 col-sm-10 col-xs-12">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="row">
							<div class="row">
								<form id="uploadform_'+code+'" class="uploadform dropzone no-margin nopadding dz-clickable min-max-height-170px bg-color-gray" data-path="" data-host="">	
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
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control width-100-p name" placeholder="Activity Title..."/>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<textarea class="form-control width-100-p m-top-10 min-height-125px description" placeholder="Activity Description..."></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="row">
						<div class="form-group has-feedback">
							<input type="text" placeholder="Date" name="ActivityDate"
								class="form-control has-feedback-left 
										datepicker datepicker-'+rid+' p-left-10" 
								aria-describedby="inputSuccess2Status3"
							/>
							<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
						</div>
					</div>
					<div class="row">
						<select class="btn-block height-34 border-gray padding-5 act-timing">
							<option value="">Timing</option>
							{!! $indication->htmlOptions('timing') !!}
						</select>
					</div>
					<div class="row m-top-10">
						<select class="btn-block height-34 border-gray padding-5 mode">
							<option value="">Mode</option>
							{!! $indication->htmlOptions('act_mode') !!}
						</select>
					</div>
					<div class="row m-top-10">
						<button class="btn btn-danger btn-block btn-remove-own unsaved" 
							data-count="'+count+'" data-uid="'+code+'" data-pdid="">
							Remove
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>