<div class="row tile_count">
	<div class="col-md-3 col-sm-6 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Total Leads</span>
		<div class="count">{{ $clientStatus->total }}</div>
		{{-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> --}}
	</div>

	{{-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Yesterday's Leads </span>
		<div class="count blue">50</div>
		<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
	</div> --}}
	
	<div class="col-md-3 col-sm-6 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Today's Leads</span>
		<div class="count green">{{ $clientStatus->todays }}</div>
		{{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> --}}
	</div>
	<div class="col-md-3 col-sm-6 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Leads to be Attend</span>
		<div class="count red">{{ $clientStatus->pending }}</div>
		{{-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> --}}
	</div>
	<div class="col-md-3 col-sm-6 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Total Follow-Up</span>
		<div class="count orange">{{ $clientStatus->follow_ups }}</div>
		{{-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> --}}
	</div>
	{{-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-clock-o"></i> Time Left</span>
		<div class="count" id="clock-div"></div>
		<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
	</div> --}}
</div>