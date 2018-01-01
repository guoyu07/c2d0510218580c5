@include('b2b.protected.dashboard.pages.hotels.partials.scripts.objects')
<script>
	{{-- bootstrap-daterangepicker --}}
	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "D/M/YYYY",

		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			postHotels({{$hotelRoute->id}});
				{{-- tbtq({{$hotelRoute->hotel->id}}, {{$hotelRoute->id}});
			sshtl({{$hotelRoute->hotel->id}}, {{$hotelRoute->id}}); --}}
		@endforeach
	});
	{{-- /bootstrap-daterangepicker --}}

	{{-- autocomplete --}}
	$(document).on('keypress paste', '#filter_search', function(e) {
		var key = e.which;
		if(key == 13){ /*the enter key code*/
			postSearchHotel();
			/*hideSpinIcon();*/
		}
		else{
			var name = $(this).val();
			if (name.length > 2) {
				/*showSpinIcon();*/
				var did = $('#tab_menu').find('.active').attr('data-did');
				url = '{{ url("dashboard/hotels/search/name") }}/'+did+'?format=json&_token='+csrf_token;
				$(this).autocomplete({ source: url });
			}
		}
	});


	$(document).on('autocompleteselect', '#filter_search', function (e, ui) {
		postSearchHotel();
		/*hideSpinIcon();*/
	});
	{{-- /autocomplete --}}

	{{-- search hotel --}}
	$(document).on('click', '#btn_filter_search', function() {
		postSearchHotel();
	});
	{{-- /search hotel --}}

	{{-- check box chenge --}}
	$(document).on('ifChanged', 'input', function() {
		checkChange(this);
	});
	{{-- /check box chenge --}}

	{{-- Choose Room --}}
	$(document).on('click','.btn-chooseRoom', function(){
		chooseRoom(this);
	});
	{{-- /Choose Room --}}

	{{-- Book hotel --}}
	$(document).on('click', '.btn-bookRoom', function(){
		bookRoom(this);
	});
	{{-- /Book hotel --}}

	{{-- Model PopUp --}}
	$(document).on('click', ".btn-link.description", function(){
		showDescription(this);
	});
	{{-- /model PopUp --}}

	{{-- click on tab menu button --}}
	$(document).on('click', '.a_tab_menu',function () {
		clickAtab(this);
	});
	{{-- click on tab menu button --}}

	{{-- next button --}}
	$(document).on('click', '#btn_next', function () {
		nextHotelEvent(this);		
	});
	{{-- /next button --}}
</script>

@include('b2b.protected.dashboard.pages.hotels.partials.scripts.function')
