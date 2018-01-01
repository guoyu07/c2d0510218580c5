<li v-for="(hotel, hotel_key) in hotels" v-cloak>
	<div class="booking-item">
		<div class="row">
			<div class="col-md-3">
				<div class="booking-item-img-wrap">
					<img :src="hotel.image" :alt="hotel.name" :title="hotel.name" height="125" />
					{{-- <div class="booking-item-img-num"><i class="fa fa-picture-o"></i>27</div> --}}
				</div>
			</div>
			<div class="col-md-6">
				<div class="booking-item-rating">
					<ul class="icon-group booking-item-rating-stars">
						<li v-for="n in 5">
							<i v-if="n <= hotel.star_rating" class="fa fa-star"></i>
							<i v-else class="fa fa-star-o"></i>
						</li>
					</ul>
					{{-- <span class="booking-item-rating-number"><b >3.7</b> of 5</span><small>(250 reviews)</small> --}}
				</div>
				<h5 class="booking-item-title" v-text="hotel.name"></h5>
				<p class="booking-item-address">
					<i class="fa fa-map-marker"></i>
					<span v-text="hotel.address"></span>
				</p>
				{{-- <small class="booking-item-last-booked">
					Latest booking: 11 hours ago
				</small> --}}
			</div>
			<div class="col-md-3">
				<span class="booking-item-price-from">from</span>
				<span class="booking-item-price font-size-35" v-text="'₹'+hotel.price"></span>
				<span>/night</span>
				{{-- <a :href="'{{ url('/hotel/details/'.$data->id) }}/'+hotel_key+'?{{ http_build_query(request()->input()) }}'" class="btn btn-primary" target="_blank">Book Now</a> --}}
				<a :href="'{{ url('/hotel/details') }}/'+id+'/'+hotel_key+'?{{ http_build_query(request()->input()) }}'" class="btn btn-primary" target="_blank">Book Now</a>
			</div>
		</div>
	</div>
</li>