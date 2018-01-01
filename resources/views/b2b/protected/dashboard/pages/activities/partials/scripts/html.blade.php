`<li class="min-height-110px activity-container li_`+activity.ukey+`">
	<div class="row">
		<div class="x_panel glowing-border `+activity.border+`">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="row">
							<div class="row height-165px">
								<img src="`+activity.image+`" alt="" height="100%" width="100%">
							</div>
						</div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12 same-height-right">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-md-11 col-sm-11 col-xs-11">
									<h2 class="search-word activity-name">`+activity.name+`</h2>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-1">
									<a href="#" class="btn-edit-activitiy">edit</a>
								</div>
							</div>
						</div>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<span class="sort-description">
								`+activity.sortDescription+`
							</span>
							<button
								class="btn-link cursor-pointer nopadding btn-description" 
								data-title="`+activity.name+` : Description" 
								data-target="#full_description_`+activity.ukey+`">More
							</button>
							<div id="full_description_`+activity.ukey+`" 
								class="full-description" hidden>`+activity.description+`
							</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12 text-right">
							<div class="row">
								<div><label>Pick Up : </label> `+activity.pickUp+`</div>
								<div><label>Duration : </label> `+activity.duration+`</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 input-container position-absolute bottom-none">
							<div class="row">
								<div class="col-md-9 col-sm-9 col-xs-12">
									<label >Timing : </label>(You can select multiple timing)
								</div>
							</div>
							<div class="row">
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="row main-timing">
										<div class="col-md-3 col-sm-3 col-xs-12">
											<label class="label-timing"><input type="checkbox" class="nomargin timing" value="fullday" `+activity.isFullday+`> Fullday</label>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-12">
											<label class="label-timing"><input type="checkbox" class="nomargin timing" value="morning" `+activity.isMorning+`> Morning</label>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-12">
											<label class="label-timing"><input type="checkbox" class="nomargin timing" value="noon" `+activity.isNoon+`> Noon</label>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-12">
											<label class="label-timing"><input type="checkbox" class="nomargin timing" value="evening" `+activity.isEvening+`> Evening</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-9 col-sm-9 col-xs-12 input-container-child">
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" placeholder="Date" 
												value="`+activity.date+`" name="ActivityDate"
												class="form-control has-feedback-left 
														datepicker datepicker-`+activity.ukey+` p-left-10 p-right-0"/>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select class="btn-block height-34 border-gray padding-5 mode">
												`+activity.modeOption+`
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<button 
										class="btn `+activity.btnClass+` btn-block btn-activity-select"
										data-ukey="`+activity.ukey+`"
										data-psid="`+activity.psid+`"
										data-code="`+activity.code+`" 
										data-vendor="`+activity.vendor+`"
										>
											<i class="fa fa-spinner fa-pulse fa-3x fa-fw font-size-20 hide"></i>
											<span class="btn-name">`+activity.btnName+`</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			{{-- <div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="pick-up-duration-box">
						<button class="btn-link pull-right toggle-group">edit</button>
						<button class="btn-link btn-link-save toggle-group" hidden>save</button>
						<button class="btn-link pull-right toggle-group" hidden>cancel</button>
						<label>Pick up</label>
						<div class="toggle-group pick-up-word">`+activity.pickUpWord+`</div>
						<input type="text" class="width-100-p pick-up toggle-group" data-inputmask="\'mask\': \'99:99\'" data-og-value="`+activity.pickUp+`" data-final-value="`+activity.pickUp+`" value="`+activity.pickUp+`" hidden>
						<div class="m-top-10"></div>
						<label>Duration : </label>
						<div class="toggle-group duration-word">`+activity.durationWord+`</div>
						<input type="text" class="width-100-p duration toggle-group" data-inputmask="\'mask\': \'99:99\'" data-og-value="`+activity.duration+`" data-final-value="`+activity.duration+`" value="`+activity.duration+`" hidden>
					</div>
				</div>
				<div class="row">
					<div class="m-top-10"></div>
					<button 
						class="btn `+activity.btnClass+` btn-block btn-activitySelect"
						data-pdid="`+activity.pdid+`"
						data-code="`+activity.code+`" 
						data-vendor="`+activity.vendor+`"
						>`+activity.btnName+`
					</button>
				</div>
			</div> --}}
		</div>
	</div>
</li>`