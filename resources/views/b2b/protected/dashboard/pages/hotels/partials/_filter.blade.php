<div class="row">	
	<div class="x_panel">
		<div class="x_title">
			<h2><div class="text-center"><i class="fa fa-filter"></i> Filter</div></h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content nopadding">
			<div class="form-group">
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
					<input type="text" v-model="search" id="filter_search" class="search form-control" placeholder="Search hotel name..">
					<i id="fa_home_filter_icon" class="fa fa-home form-control-feedback right-1 right" aria-hidden="true"></i>
					<i id="fa_spin_filter_icon" class="fa fa-spinner fa-pulse fa-3x fa-fw font-size-20 errspan hide"></i>
				</div>
				
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-12">
						<button id="btn_filter_search" class="btn btn-success btn-block m-top-10">Find</button>
					</div>
				</div>
				{{-- <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
					<select class="btn-block height-30 border-gray padding-5 filterSelect">
						<option selected>Sort By</option>
						<option value="hotelName" >Hotel Name</option>
						<option value="hotelPrice" >Price L-H</option>
						<option value="hotelPrice" >Price H-L</option>
						<option value="starRating" >Star Rating L-H</option>
						<option value="starRating" >Star Rating H-L</option>
					</select>
				</div> --}}
			</div>
		</div>
	</div>
</div>