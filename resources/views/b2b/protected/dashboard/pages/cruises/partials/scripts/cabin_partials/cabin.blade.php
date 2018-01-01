<div id="roomresult" class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 padding-10">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 main-cabinContainer">
				<div class="row">
					{{-- cabin Type Image Div  --}}
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="row">
							<div class="height-120px">
								<img src="'+cabin.image+'" alt="" height="100%" width="100%">
							</div>
						</div>
					</div>
					{{-- /cabin Type Image Div  --}}

					{{-- cabin type main Container --}}
					<div class="col-md-7 col-sm-7 col-xs-12">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-5">
								<div class="font-size-20">'+cabin.cabin+'</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-5">
								<div class="col-md-6 col-sm-6 col-xs-6 pick-drop-container">
									<div class="col-md-2 col-sm-2 col-xs-2">
										<div class="checkbox">
											<label class="nopadding width-100-p">
												<input type="checkbox" class="flat" data-type="pick_up">
											</label>
										</div>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop">Add Pick-Up</div>
									<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop" style="display: none;">
										<select class="btn-block border-gray padding-5 h-pick-up"
											data-selected="0">
											<option value="">Pick-Up From?</option>
											<option value="airport">Airport</option>
											<option value="hotel">Hotel</option>
											<option value="cruise">Cruise/Ferry</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 pick-drop-container">
									<div class="col-md-2 col-sm-2 col-xs-2">
										<div class="checkbox">
											<label class="nopadding width-100-p">
												<input type="checkbox" class="flat" data-type="drop_off">
											</label>
										</div>
									</div>
									<div class="col-md-10 col-sm-10 col-xs-10 p-top-2 m-top-10 pick-drop">Add Drop-Off</div>
									<div class="col-md-10 col-sm-10 col-xs-10 m-top-10 select-pick-drop" style="display: none;">
										<select class="btn-block border-gray padding-5 h-drop-off" 
											data-selected="0">
											<option value="">Drop Off To?</option>
											<option value="airport">Airport</option>
											<option value="hotel">Hotel</option>
											<option value="cruise">Cruise/Ferry</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-2 col-sm-2 col-xs-12">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-10 pull-right">
								{{-- <div>
									<h3 class="text-center">
										<i class="fa fa-rupee font-size-20">
										</i><span>{{ $agentPrice->price_per_cabin_night }}</span>
									</h3> 
								</div> --}}
								<div class="m-top-20">
									<button class="btn btn-block btn-primary btn-book-cabin" 
										data-id="'+cabin.id+'" 
										data-did="'+cabins.did+'"
										data-rid="'+cabins.rid+'"
										data-vendor="'+cabins.vendor+'" 
										data-isseleted="0">Add
									</button>
								</div>
							</div>
						</div>
					</div>
					{{-- /cabin type main Container --}}
				</div>
			</div>
		</div>
	</div>
</div>
