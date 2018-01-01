<li class="m-top-10 main-list-item li_'+hotel.ukey+'">
	<div class="x_panel glowing-border">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row height-150px">
					<img src="'+hotel.image+'" alt="" height="100%" width="100%">
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h3 class="search-word">'+hotel.name+' '+hotel.starRatingHtml+'</h3>
						<p class="starRating" hidden>'+hotel.starRating+'</p>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
						<i class="fa fa-map-marker"></i>
						<span> '+hotel.sortAddress+'</span>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
						'+hotel.sortDescription+'
						<button class="btn-link cursor-pointer description" 
							data-title="'+hotel.name+' : Description" 
							data-bodyid="hotelDescription'+hotel.ukey+'">More
						</button>
						<div id="hotelDescription'+hotel.ukey+'" hidden>'+hotel.description+'</div>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-50">
						<button 
							class="btn '+hotel.btnClass+' btn-block btn-chooseRoom off" 
							data-hid="'+hotel.code+'"
							data-hdid="'+hotel.hdid+'" {{-- package_hotel_id --}}
							data-vdr="'+hotel.vendor+'">'+hotel.btnName+'
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row hotel-detail off" style="display: none;">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div id="exTab1" class="container">
							<ul  class="nav nav-pills">
								<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
									<a href="#'+hotel.ukey+'_'+hotel.ridObj.rid+'_rooms" data-toggle="tab">Rooms</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+hotel.ukey+'_'+hotel.ridObj.rid+'_about" data-toggle="tab">About</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+hotel.ukey+'_'+hotel.ridObj.rid+'_map" data-toggle="tab">Map</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+hotel.ukey+'_'+hotel.ridObj.rid+'_gallary" data-toggle="tab">Gallary</a>
								</li>
							</ul>
							<div class="tab-content tab-container scroll-bar clearfix">
								<div id="'+hotel.ukey+'_'+hotel.ridObj.rid+'_rooms" class="tab-pane active"></div>
								<div id="'+hotel.ukey+'_'+hotel.ridObj.rid+'_about" class="tab-pane">
									'+hotel.description+'
								</div>
								<div id="'+hotel.ukey+'_'+hotel.ridObj.rid+'_map" class="tab-pane" data-src="https://maps.google.com/maps?q='+hotel.latitude+','+hotel.longitude+'&hl=es;z=14&amp;output=embed"></div>
								<div id="'+hotel.ukey+'_'+hotel.ridObj.rid+'_gallary" class="tab-pane">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel">
											<div class="x_content" >
												<div class="gallery cf"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>