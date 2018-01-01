<li class="m-top-10 main-list-item li_'+accomo.ukey+'">
	<div class="x_panel glowing-border '+accomo.search_class+'">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row height-150px">
					<img src="'+accomo.image+'" alt="" height="100%" width="100%">
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h3 class="search-word">
							<span class="hotel-name">'+accomo.name+' </span>'+accomo.starRatingHtml+'
						</h3>
						<p class="starRating" hidden>'+accomo.starRating+'</p>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
						<i class="fa fa-map-marker"></i>
						<span> '+accomo.sortAddress+'</span>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
						'+accomo.sortDescription+'
						<button class="btn-link cursor-pointer description" 
							data-title="'+accomo.name+' : Description" 
							data-bodyid="description'+accomo.ukey+'">More
						</button>
						<div id="description'+accomo.ukey+'" hidden>'+accomo.description+'</div>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-50">
						<button 
							class="btn '+accomo.btnClass+' btn-block btn-choose-prop off" 
							data-id="'+accomo.id+'"
							data-psid="'+accomo.psid+'"
							data-idx="'+accomo.index+'"
							data-ukey="'+accomo.ukey+'"
							data-vdr="'+accomo.vendor+'">'+accomo.btnName+'
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
									<a href="#'+accomo.ukey+'_'+accomo.rtoken+'_props" data-toggle="tab">'+accomo.propTabName+'</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+accomo.ukey+'_'+accomo.rtoken+'_about" data-toggle="tab">About</a>
								</li>';
								if(accomo.route.mode == 'hotel'){
									appendHtml += '<li class="col-md-2 col-sm-2 col-xs-12 text-center">
										<a href="#'+accomo.ukey+'_'+accomo.rtoken+'_map" data-toggle="tab">Map</a>
									</li>';
								}
								appendHtml += '<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+accomo.ukey+'_'+accomo.rtoken+'_gallary" data-toggle="tab">Gallary</a>
								</li>
							</ul>
							<div class="tab-content tab-container clearfix">
								
								<div id="'+accomo.ukey+'_'+accomo.rtoken+'_props" class="tab-pane active">
									{{-- <div class="row border-gray m-top-5">
										<div class="col-md-5 col-sm-5 col-xs-5">
											@include($viewPath.'.partials.html_partials.transfer')
										</div>
										<div class="col-md-7 col-sm-7 col-xs-7">
											@include($viewPath.'.partials.html_partials.meal')
										</div>
									</div> --}}
									<div class="row inner-tab-container scroll-bar m-top-5">
										<div class="col-md-12 col-sm-12 col-xs-12 tab-room">

										</div>
									</div>
									<div class="row">
										<div class="m-top-10"></div>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<button class="btn btn-primary pull-right add-room-manually">Add Room Manually</button>
										</div>
									</div>
								</div>

								<div id="'+accomo.ukey+'_'+accomo.rtoken+'_about" class="tab-pane">
									<div class="row inner-tab-container scroll-bar m-top-5">
										<div class="col-md-12 col-sm-12 col-xs-12">
											'+accomo.description+'
										</div>
									</div>
								</div>

								<div id="'+accomo.ukey+'_'+accomo.rtoken+'_map" class="tab-pane tab-map-container" data-src="https://maps.google.com/maps?q='+accomo.latitude+','+accomo.longitude+'&hl=es;z=14&amp;output=embed">
									<div class="row inner-tab-container scroll-bar m-top-5">
										<div class="col-md-12 col-sm-12 col-xs-12 tab-map">
										</div>
									</div>
								</div>

								<div id="'+accomo.ukey+'_'+accomo.rtoken+'_gallary" class="tab-pane">
									<div class="row inner-tab-container scroll-bar m-top-5">
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
	</div>
</li>