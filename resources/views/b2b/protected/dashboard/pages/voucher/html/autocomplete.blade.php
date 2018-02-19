<script>
	$(document).on('keyup paste', '.accommo-name', function(e) {
		var dest_id = $('.location').attr('data-code');

		$(this).autocomplete({
			minLength: 4,
			source: function (request, response) {
				request = $.extend(request, {
					'format' : 'json',
					'_token' : csrf_token,
					'dest_id' : dest_id
				});
		    $.ajax({
				  type: "POST",
				  url:"{{ route("vouchers.show_accommodation") }}",
				  data: request,
				  success: response,
				  dataType: 'json'
				});
			},
			focus: function( event, ui ) {
				$(this).val( _.get(ui, 'item.name', '') );
				return false;
			},
			select: function( event, ui ) {
				$(this).val( _.get(ui, 'item.name', ''))
								.attr('data-code', _.get(ui, 'item.code', ''))
									.attr('data-image', _.get(ui, 'item.image', ''))
										.attr('data-vendor', _.get(ui, 'item.vendor', ''));
				return false;
			}
		})
		.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
			return $( "<li>" )
			.append( "<a>" + _.get(item, 'name', '') + "</a>" )
			.appendTo( ul );
		};
	});



	$(document).on('keypress', '.location', function(e) {
		$(this).autocomplete({
			minLength: 3,
			source: '{{ route('destination.names') }}',
			focus: function( event, ui ) {
				$(this).val(_.get(ui, 'item.fullname', _.get(ui, 'item.name', '')));
				return false;
			},
			select: function( event, ui ) {
				event.preventDefault();

				$(this).val(_.get(ui, 'item.fullname', _.get(ui, 'item.name', '')))
									.attr('data-match', _.get(ui, 'item.fullname', _.get(ui, 'item.name', '')))
										.attr('data-code', _.get(ui, 'item.airport_code', _.get(ui, 'item.code', '')))
											.removeClass('inctv')
												.removeClass('border-red');

				return false;
			}
		})
		.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
			return $( "<li>" )
			.append( "<a>" + _.get(item, 'fullname', _.get(item, 'name', '')) + "</a>" )
			.appendTo( ul );
		};
	});


	$(document).on('keyup paste', '.contact', function(e) {
		$(this).autocomplete({
			minLength: 4,
			source: function (request, response) {
				request = $.extend(request, {
					'format' : 'json',
					'_token' : csrf_token,
				});

		    $.ajax({
				  type: "POST",
				  url:"{{ route("vouchers.client_info") }}",
				  data: request,
				  success: response,
				  dataType: 'json'
				});
			},

			focus: function( event, ui ) {
				$(this).val( _.get(ui, 'item.mobile', '') );
				return false;
			},

			select: function( event, ui ) {
				$(this).val( _.get(ui, 'item.mobile', '') )
								.attr('data-token', _.get(ui, 'item.token', ''));
				$('span.name').text(_.get(ui, 'item.name', ''));
				$('span.email').text(_.get(ui, 'item.email', ''));
				return false;
			}
		})
		.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
			return $( "<li>" )
			.append( "<a>" + _.get(item, 'name', '')+' ('+_.get(item, 'mobile', '')+')' + "</a>" )
			.appendTo( ul );
		};
	});
</script>