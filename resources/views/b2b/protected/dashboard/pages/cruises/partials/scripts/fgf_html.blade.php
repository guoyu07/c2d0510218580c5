<li class="m-top-10">
	<div class="x_panel glowing-border">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row height-150px">
					<img src="'+cruiseImage+'" alt="" height="100%" width="100%">
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12">
				<h2>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h3 class="search-word">'+cruiseName+'</h3>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 ">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 m-top-5">
								'+starRatingHtml+'
								<div hidden>
									<p class="starRating" >'+starRating+'</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
						{{-- <b>Amenities : </b> '+amtis+' --}}
					</div>
				</h2>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-50">
						<input type="button" class="btn btn-primary btn-block btn-chooseRoom" value="Rooms" 
							data-vendor="f" 
							data-did="'+ids.did+'"
							data-uid="'+uniqueKey+'"
							data-elemid="'+ids.elem_id+'" 
							data-index="'+i+'" 
						/>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div id="cruisedetail-'+uniqueKey+'" class="col-md-12 col-sm-12 col-xs-12 classCruiseDetail" style="display: none;">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="container">
							<ul  class="nav nav-pills">
								<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
									<a  href="#'+uniqueKey+'_a" data-toggle="tab">Rooms</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+uniqueKey+'_b" data-toggle="tab">About</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+uniqueKey+'_c" data-toggle="tab">Gallary</a>
								</li>
							</ul>
							<div id="main_cruiseDetail_'+uniqueKey+'" class="tab-content main-cruiseDetail scroll-bar clearfix">
								<div id="'+uniqueKey+'_a" class="tab-pane active"></div>
								<div id="'+uniqueKey+'_b" class="tab-pane"></div>
								<div id="'+uniqueKey+'_c" class="tab-pane"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>