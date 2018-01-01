<ul class="booking-list" v-cloak>
	<li v-for="room in roomsData">
		<div class="booking-item">
			<div class="row">
				<div class="col-md-3">
					<img src="{!! urlDefaultImageRoom() !!}" alt="Image Alternative text" title="The pool" />
				</div>
				<div class="col-md-5">
					<h5 class="booking-item-title" v-text="room.room_type"></h5>
					{{-- <p class="text-small">Sit cras diam nec morbi erat mi at quam consectetur praesent litora mauris</p> --}}
					{{-- <ul class="booking-item-features booking-item-features-sign clearfix">
						<li rel="tooltip" data-placement="top" title="Adults Occupancy"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 3</span>
						</li>
						<li rel="tooltip" data-placement="top" title="Beds"><i class="im im-bed"></i><span class="booking-item-feature-sign">x 1</span>
						</li>
						<li rel="tooltip" data-placement="top" title="Room footage (square feet)"><i class="im im-width"></i><span class="booking-item-feature-sign">450</span>
						</li>
					</ul>
					<ul class="booking-item-features booking-item-features-small clearfix">
						<li rel="tooltip" data-placement="top" title="Air Conditioning"><i class="im im-air"></i>
						</li>
						<li rel="tooltip" data-placement="top" title="Flat Screen TV"><i class="im im-tv"></i>
						</li>
						<li rel="tooltip" data-placement="top" title="Mini Bar"><i class="im im-bar"></i>
						</li>
						<li rel="tooltip" data-placement="top" title="Kitchen"><i class="im im-kitchen"></i>
						</li>
						<li rel="tooltip" data-placement="top" title="SPA tub"><i class="im im-spa"></i>
						</li>
						<li rel="tooltip" data-placement="top" title="Terrace"><i class="im im-terrace"></i>
						</li>
						<li rel="tooltip" data-placement="top" title="Washing Machine"><i class="im im-washing-machine"></i>
						</li>
						<li rel="tooltip" data-placement="top" title="Pool"><i class="im im-pool"></i>
						</li>
					</ul> --}}
				</div>
				<div class="col-md-4">
					<span class="booking-item-price">
						₹ <span v-text="room.price"></span>
					</span>
					<span>/night</span>
					<button :data-id="room.id" :data-sequence="room.sequence" :data-source="room.source" class="btn btn-primary btn-select-room">Select</button>
				</div>
			</div>
		</div>
	</li>
</ul>