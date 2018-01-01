@include('b2b.protected.dashboard.pages.cruises.partials.scripts.objects')
<script>
	{{-- bootstrap-daterangepicker --}}
	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "DD/MM/YYYY",

		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

		@foreach ($package->cruiseRoutes as $cruiseRouteKey => $cruiseRoute)
			postFgfCruise({{$cruiseRoute->id}});
		@endforeach

		// console.log(isset([{"a":"a"}, {"a":"a"}], 2));
	});

	{{-- /bootstrap-daterangepicker --}}

	{{-- filter List.js--}}

	var filter = {
		@foreach ($package->cruiseRoutes as $cruiseRouteKey => $cruiseRoute)
			'cruise_{{ $cruiseRoute->id }}' : '',
		@endforeach
		initFilter : function (targetList) {
			var options = {
				valueNames: ['search-word']
			};
			@foreach ($package->cruiseRoutes as $cruiseRouteKey => $cruiseRoute)
				if (targetList == {{ $cruiseRoute->id }}) {
					this.cruise_{{ $cruiseRoute->id }} = new List("cruise_{{ $cruiseRoute->id }}_div", options);
				}
			@endforeach
		}
	}
	



	$(document).on('keypress keyup keydown paste', "#filter_search", function(){
		var targetList = $('#tab_menu').find('.active').attr('data-list');
		// console.log(targetList);
		var search = $(this).val();
		@foreach ($package->cruiseRoutes as $cruiseRouteKey => $cruiseRoute)
			if (targetList == "cruise_{{ $cruiseRoute->id }}_div") {
				filter.cruise_{{ $cruiseRoute->id }}.search(search);
			}
		@endforeach
	});


	{{-- /filter List.js --}}


	$(document).on('ifChanged', 'input', function() {
		var type = $(this).attr('data-type');
		var isChecked = $(this).is(':checked');
		var parent = $(this).closest('.pick-drop-container');
		if (type == 'pick_up') {
			if (isChecked) {
				$(parent).find('.pick-drop').hide();
				$(parent).find('.select-pick-drop').show();
				$(parent).find('.h-pick-up').attr('data-selected', 1);
			}
			else{
				$(parent).find('.select-pick-drop').hide();
				$(parent).find('.pick-drop').show();
				$(parent).find('.h-pick-up').attr('data-selected', 0);
			}
		}
		else if (type == 'drop_off') {
			if (isChecked) {
				$(parent).find('.pick-drop').hide();
				$(parent).find('.select-pick-drop').show();
				$(parent).find('.h-drop-off').attr('data-selected', 1);
			}
			else{
				$(parent).find('.select-pick-drop').hide();
				$(parent).find('.pick-drop').show();
				$(parent).find('.h-drop-off').attr('data-selected', 0);
			}
		}
	});


	{{-- Choose Room --}}

	$(document).on('click','.btn-chooseRoom', function(){
		var parent = $(this).closest('.main-li');
		$(parent).find('.toggle-detail').toggle();
		changeChooseBtn(this);
	});

	{{-- /Choose Room --}}



	{{-- Book hotel --}}

	$(document).on('click', '.btn-book-cabin', function(){
		$('#loging_log').show();
		changeBookBtn(this);

		var vdr = $(this).attr('data-vendor');
		var parent = $(this).closest('.main-cabinContainer');
		var cabinId = $(this).attr('data-id');
		var rid = $(this).attr('data-rid');
		var elem_id = 'cruise_'+rid;
		var ridObj = getRidObject(rid);
		var did = ridObj.did;
		var next_did = ridObj.next_did;
		var next_rid = ridObj.next_rid;
		var pickUpVal = $(parent).find('.h-pick-up').val();
		var dropOffVal = $(parent).find('.h-drop-off').val();
		var pickUpSelect = $(parent).find('.h-pick-up').attr('data-selected');
		var dropOffSelect = $(parent).find('.h-drop-off').attr('data-selected');

		var data = {
			"_token" : csrf_token,
			"cbid" : cabinId,
			"vdr" : vdr,
			"did" : did,
			"pu" : pickUpVal, 	{{-- pick_up --}}
			"pus" : pickUpSelect, 	{{-- pick_up_selected --}}
			"do" : dropOffVal, 	{{-- drop_off --}}
			"dos" : dropOffSelect, 	{{-- drop_off_selected --}}
			"next_rid" : next_rid,
		}

		postAddtoCartCruise(data);


		if (next_rid != "NaN") {
			setTimeout(function () {   
				postFgfCruise(next_rid);
				$('#loging_log').hide();

		  }, 3000)
		}else{
			setTimeout(function () {
				$('#loging_log').hide();

				document.location.href = "{{ url('/dashboard/package/builder/event/'.$package->id.'/cruise') }}";
		  }, 3000)
		}
	});
	{{-- /Book hotel --}}

</script>
@include('b2b.protected.dashboard.pages.cruises.partials.scripts.function')