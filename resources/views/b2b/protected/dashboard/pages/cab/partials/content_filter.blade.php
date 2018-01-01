<div class="x_panel m-bottom-20px">
	<div class="x_title noborder nomargin">
		<div class="col-md-1 col-sm-1 col-xs-12 nopadding">
			<h2><div class="text-center"><i class="fa fa-filter"></i> Filter</div></h2>
		</div>
		<div class="col-md-11 col-sm-11 col-xs-12">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<input type="text" id="filter_hotelname" class="search btn-block height-30 border-gray padding-5" placeholder="Flight Name">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div hidden>
					<button id="filterButton" class="sort" data-sort="">Sort</button>
				</div>
				<select class="btn-block height-30 border-gray padding-5 filterSelect">
					<option selected>Short By</option>
					<option value="hotelName" >Hotel Name</option>
					<option value="hotelPrice" >Price L-H</option>
					<option value="hotelPrice" >Price H-L</option>
					<option value="starRating" >Star Rating L-H</option>
					<option value="starRating" >Star Rating H-L</option>
				</select>
			</div>
		</div>
		{{-- <div class="col-md-1 col-sm-1 col-xs-12 nopadding" style="display: none;">
			<ul class="nav navbar-right panel_toolbox panel_toolbox1">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
			</ul>
		</div> --}}
		<div class="clearfix"></div>
	</div>
	<div class="x_content nopadding" style="display: none;">
		<div class="form-group"></div>
	</div>
</div>