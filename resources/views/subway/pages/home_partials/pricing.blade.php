<div class="row p-right-5">
	<div class="square mod-box-color1">
		<div class="square-content text-center">
			<div class="tile-title m-bottom-5px">
				<b>Hi {{ $package->client->fullname }}</b>
			</div>

			<div class="tile-line">
				<i class="fa fa-rupee"></i>
				<b> {{ $package->cost->total_cost }} per person</b>
			</div>
			<div class="tile-line"><b>for : {{ $package->nights}} nights/{{ $package->nights+1 }} days</b></div>
			<div class="tile-line"><b>s no. : {{ $package->uid}}</b></div>
			<a href="#" class="show-book-popup">
				<div class="down-title">Book Now</div>
			</a>
		</div>
	</div>
</div>