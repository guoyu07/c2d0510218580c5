@extends('traveler.layout.main')

@section('title', $data->hotel_name)

@section('content')
<div class="gap"></div>

<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="row">
				{{-- @include('traveler.pages.hotel.block.cards') --}}
				{{-- @include('traveler.pages.hotel.block.new_card') --}}
				@include('traveler.pages.hotel.block.guest')
				<button id="book_now" class="btn btn-primary">Book Now</button>
				<a href="" id="a_book_now"></a>
			</div>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					@include('traveler.pages.hotel.block.hotel')
				</div>
			</div>
		</div>
	</div>
	<div class="gap"></div>
</div>

@endsection

@section('scripts')
	<script>
		$(document).on('click', '#book_now', function () {
			var room_guest = [];

			$('.room-guest').each(function(roomKey, room){
				
				var new_guest = [];
				var email = $(this).find('.email').val();
				var phone = $(this).find('.phone').val();
				$(this).find('.guest-row').each(function(guestKey, guest){
					
					if (guestKey) {
						email = null;
						phone = null;
					}

					new_guest.push({
						'email' : email,
						'phone' : phone,
						'prefix' : $(this).find('.prefix').val(),
						'name' : $(this).find('.name').val(),
						'age' : $(this).find('.age').val(),
					});
				});

				room_guest.push(new_guest);
			});

			var query = $.param({'guests' : room_guest});

			var url = '{{ url('hotel') }}/{{ $data->id }}/room/book?{!! http_build_query(request()->input()) !!}&'+query;

			$('#a_book_now').attr('href', url);

			document.getElementById('a_book_now').click();
		});
	</script>
@endsection