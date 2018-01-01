<script>

	$(document).ready(function () {
		setGuestsWord();

		setTimeout(function () {
			@if (isset(request()->start))
				$('[name="start"]').datepicker('setDate',  '{{ request()->start }}');
			@endif

			@if (isset(request()->end)) 
				$('[name="end"]').datepicker('setDate',  '{{ request()->end }}');
			@endif

	  }, 200);
	});

	$(function() {
		$('.dropdown.keep-open').on({
				"shown.bs.dropdown": function() {
						$(this).data('closable', false);
				},
				"click": function(event) {
						$(this).data('closable', false);
				},
				"hide.bs.dropdown": function(event) {
						temp = $(this).data('closable');
						$(this).data('closable', true);
						return temp;
				}
		});
	});

	$(document).on('change', '.adult', function () {
		setGuestsWord();
	});

	$(document).on('click', '.remove-kid', function () {
		$('.kids-box [type="radio"]').prop('checked', false);
		$('.kids-box').find('.active').removeClass('active');
		$('.kids-age').prop('disabled', true);
		$('.remove-kid').addClass('hide');
		setGuestsWord();
	});

	$(document).on('click', '.kids-box .btn.btn-primary', function () {

		parent = $(this).closest('.room');
		kids = parseInt($(this).find('.kids').val());
		
		$(parent).find('.remove-kid').removeClass('hide');

		$(parent).find('.kids-age')
							.slice(0, kids).prop('disabled', false);

		$(parent).find('.kids-age')
							.slice(kids).prop('disabled', true);

		setTimeout(function () {   
			setGuestsWord();
		}, 200);
	});

	$(document).on('click', '.add-room', function () {
		var count = parseInt($(this).attr('data-count'));
		var rooms = $('.rooms-container');
		if (rooms.children().length < 4) {
			// console.log('rooms['+count+'][adult]');
			var html = '{!! myview('traveler.pages.index.rooms') !!}';
			$(rooms).append(html);
		}

		if (rooms.children().length == 4) {
			$(this).addClass('hide');
		}
		$(this).attr('data-count', count+1);
		setGuestsWord();
	});

	$(document).on('click', '.remove-room', function () {
		$(this).closest('.room').remove();
		if ($('.rooms-container').children().length < 4) {
			$('.add-room').removeClass('hide');
		}
		setGuestsWord();
	});


	$(document).on('keyup paste', '.autocomplete', function(e) {
		var name = $(this).val();
		if (name.length > 2) {

			$(this).autocomplete({
				minLength: 0,
				source: '{{ route('destination.names') }}?v=tbtq',
				focus: function( event, ui ) {
					$(this).val( ui.item.name );
					return false;
				},
				select: function( event, ui ) {
					$(this).val( ui.item.name );
					$('[name="dest_code"]').val(ui.item.code);
					return false;
				}
			})
			.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
				return $( "<li>" )
				.append( "<a>" + item.name + "</a>" )
				.appendTo( ul );
			};
		}
	});

	function setGuestsWord() {
		var adult = 0;
		var kids = 0;
		$('.room').each(function (i, v) {
			adult += parseInt($(v).find('.adult:checked').val());
			var k = parseInt($(v).find('.kids:checked').val());
			if (!isNaN(k)) { kids += k }
		});
		word = adult+(adult > 1 ? ' Adults' : ' Adult');
		word += kids > 0 ? ', '+kids+(kids > 1 ? ' Kids' : 'Kid') : '';
		$('.guests-word').html(word);
		return false;
	}

</script>