<div class="row">	
	<div class="x_panel">
		<div class="x_title">
			<h2><div class="text-center"><i class="fa fa-filter"></i> Filter</div></h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content nopadding">
			<div class="form-group">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<input type="text" v-model="search" id="filter_search" class="search form-control" placeholder="Search flight name, no...">
						<i class="fa fa-plane form-control-feedback right-1 right" aria-hidden="true"></i>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
						<h4>Stops</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-3">
						<label>
							<input type="checkbox" class="search-stop nomargin" data-value="stop_1"> 0
						</label>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3">
						<label>
							<input type="checkbox" class="search-stop nomargin" data-value="stop_2"> 1
						</label>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3">
						<label>
							<input type="checkbox" class="search-stop nomargin" data-value="stop_3"> 2
						</label>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3">
						<label>
							<input type="checkbox" class="search-stop nomargin" data-value="stop_4"> 3
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>