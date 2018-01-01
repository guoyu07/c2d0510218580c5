<script>
	$(document).on('keypress', '.location', function(e) {
		var parent = $(this).closest('.destinationList');
		var mode = $(parent).find('.mode').val();
		var name = $(this).attr('name');

		if (mode == '') {
			$(parent).find('.mode').addClass('border-red');
			return false;
		}
			
		var	url = '{{ route('destination.names') }}';

		if (mode == 'flight') {
			url = '{{ route('airport.names') }}?tags=flight';
		}
		else if(mode == 'cruise'){
			url += '?tags=cruise';
		}

		$(parent).find('.mode').removeClass('border-red');
		
		if ($(this).attr('data-match') != $(this).val()) {
			$(this).addClass('inctv');
			changeInRoute(parent);
		}

		$(this).autocomplete({
			minLength: 0,
			source: url,
			focus: function( event, ui ) {
				if (mode == 'flight') {
					$(this).val( ui.item.fullname );
				}
				else{
					$(this).val( ui.item.name );
				}
				return false;
			},
			select: function( event, ui ) {
				if (mode == 'flight') {
					$(this).val( ui.item.fullname )
									.attr('data-match', ui.item.fullname)
										.attr('data-code', ui.item.airport_code);
				}
				else{
					$(this).val( ui.item.name )
									.attr('data-code', ui.item.code)
										.attr('data-match', ui.item.name);
				}

				$(this).removeClass('inctv')
								.removeClass('border-red');

				return false;
			},
			change: function( event, ui ) {
				if (mode == 'flight') {
					$(this).val( ui.item.fullname )
									.attr('data-match', ui.item.fullname)
										.attr('data-code', ui.item.airport_code);
				}
				else{
					$(this).val( ui.item.name )
									.attr('data-code', ui.item.code)
										.attr('data-match', ui.item.name);
				}

				$(this).removeClass('inctv')
								.removeClass('border-red');

				return false;
			}
		})
		.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
			var newName = mode == 'flight' ? item.fullname : item.name;

			return $( "<li>" )
			.append( "<a>" + newName + "</a>" )
			.appendTo( ul );
		};
	});

</script>