<li class="m-top-10 main-li">
	<div class="x_panel glowing-border">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row height-150px">
					<img src="'+cruise.image+'" alt="" height="100%" width="100%">
				</div>
			</div>
			<div class="col-md-7 col-sm-7 col-xs-12">
				<h2>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h3 class="search-word">'+cruise.name+'</h3>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 ">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4 m-top-5">
								'+cruise.starRatingHtml+'
								<div hidden>
									<p class="starRating" >'+cruise.starRating+'</p>
								</div>
							</div>
						</div>
					</div>
				</h2>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-50">
						<button class="btn btn-primary btn-block btn-chooseRoom" data-isseleted="0">Cabins</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div id="cruisedetail-'+cruise.id+'" class="col-md-12 col-sm-12 col-xs-12 toggle-detail" style="display: none;" >
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="container">
							<ul  class="nav nav-pills">
								<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
									<a  href="#'+cruise.id+'_a" data-toggle="tab">Rooms</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+cruise.id+'_b" data-toggle="tab">About</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#'+cruise.id+'_c" data-toggle="tab">Gallary</a>
								</li>
							</ul>
							<div id="main_cruiseDetail_'+cruise.id+'" class="tab-content main-hotelDetail scroll-bar clearfix">
								@include('b2b.protected.dashboard.pages.cruises.partials.scripts.cabins')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>