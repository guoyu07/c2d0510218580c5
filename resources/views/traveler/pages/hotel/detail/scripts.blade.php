
{{-- <script src="{{ url('/') }}/js/axios/0.16.2/axios.min.js"></script> --}}
{{-- <script src="{{ url('/') }}/js/vue/2.0.3/vue.js"></script> --}}
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.3/vue.js"></script>
<script>
	var commonData = {
			 search: '',
			 roomId: '',
			 detailId: '',
			 roomsData: [],
			 gotDetails : false,
			 detailsData : {},
		};

	var gallery = new Vue({
		el: '#photo_gallery',
		data: commonData,

		mounted : function () {
			this.details()
		},

		methods  : {
			details : function () {
				var self = this;
				axios.get('{!! url('api/hotel/'.$id.'/'.$index.'/details').'?'.http_build_query(request()->input()) !!}')
				.then(function (response) {
					// console.log(response);
					if (response.data.details != null) {
						commonData.detailsData = response.data.details
						commonData.detailId = response.data.id
						commonData.gotDetails = true;
						self.$nextTick(function(){
					    $('.fotorama').fotorama();
			      })
					}
				})
				.catch(function (error) {
					// console.log(error)
				});
			},
		}
	});

	var room = new Vue({
		
		el: '#rooms',
		
		data: commonData,

		mounted : function () {
			this.rooms()
		},

		methods  : {
			rooms : function () {
				// var self = this
				axios.get('{!! url('api/hotel/'.$id.'/'.$index.'/rooms').'?'.http_build_query(request()->input()) !!}')
				.then(function (response) {
					// console.log(response);
					commonData.roomsData = response.data.rooms
					commonData.roomId = response.data.id
					self.$nextTick(function(){
						initNiceScroll();
					});
				})
				.catch(function (error) {
					// console.log(error)
				});
			}
		}
	});


	$(document).on('click', '.proceed-book', function(){
		doClickEvent();
	});

	$(document).on('click', '.btn-select-room', function(){
		var parent = $(this).closest('.booking-item');

		if ($(this).hasClass('btn-primary')) {
			$(this).addClass('btn-blue')
							.removeClass('btn-primary')
								.text('Remove');
			$(parent).addClass('border-blue-2px');

			checkSource(this);
		}
		else if ($(this).hasClass('btn-blue')) {
			$(this).addClass('btn-primary')
							.removeClass('btn-blue')
								.text('Select');
			$(parent).removeClass('border-blue-2px');

			checkSource(this);
		}
	});


	function doClickEvent() {
		var inx = [];

		$('.btn-blue.btn-select-room').each(function(){
			var id = $(this).attr('data-id');
			inx.push(id);
		});

		var query = $.param({'inx' : inx});

		var url = '{{ url('hotel') }}/'+commonData.roomId+'/room/block?{!! http_build_query(request()->input()) !!}&'+query;
		
		$('#new_link').attr('href', url);

		document.getElementById('new_link').click();
	}

	function checkSource(el) {
		var isSelected = $(el).hasClass('btn-blue'),
		parent = $('.booking-list'),
		source = $(el).attr('data-source'),
		sequence = $(el).attr('data-sequence');

		if (source == 'FixedCombination') {
			if (isSelected) {
				$('.booking-list .btn-primary:not([data-sequence="'+sequence+'"])').each(function(){
					$(this).addClass('btn-gray')
									.removeClass('btn-primary')
										.prop('disabled', true);
				});
			}
			else{
				$(parent).find('.btn-gray:not([data-sequence="'+sequence+'"])').each(function(){
					$(this).addClass('btn-primary')
									.removeClass('btn-gray')
										.prop('disabled', false);
				});
			}
		}
		else if (source == 'OpenCombination') {

			if (isSelected) {
				$('.booking-list .btn-primary[data-sequence="'+sequence+'"]').each(function(){
					$(this).addClass('btn-gray')
									.removeClass('btn-primary')
										.prop('disabled', true);
				});
			}
			else{
				$(parent).find('.btn-gray[data-sequence="'+sequence+'"]').each(function(){
					$(this).addClass('btn-primary')
									.removeClass('btn-gray')
										.prop('disabled', false);
				});
			}
		}
	}
</script>