<script>
	$(document).on('keyup paste', '.accommo-name', function(e) {
		var dest_id = $('.accommodation-popup-box')
										.find('.location').attr('data-code');

		// var serviceChildBox = $(this).closest('.service-child-box');

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

	$(document).on('keyup paste', '.prop-type', function(e) {
		var parent = $(this).closest('.accommodation-popup-box');
		var accommo = $(parent).find('input.accommo-name');

		$(this).autocomplete({
			minLength: 4,
			source: function (request, response) {
				request = $.extend(request, {
					'format' : 'json',
					'_token' : csrf_token,
					'id' : $(accommo).attr('data-code'),
					'vendor' : $(accommo).attr('data-vendor')
				});
		    $.ajax({
				  type: "POST",
				  url:"{{ route('vouchers.show_accommodation_props') }}",
				  data: request,
				  success: response,
				  dataType: 'json'
				});
			},
			focus: function( event, ui ) {
				$(this).val( _.get(ui, 'item.property_type', '') );
				return false;
			},
			select: function( event, ui ) {
				$(this).val( _.get(ui, 'item.property_type', ''))
								.attr('data-id', _.get(ui, 'item.id', ''))
									.attr('data-vendor', _.get(ui, 'item.vendor', ''));

				return false;
			}
		})
		.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
			return $( "<li>" )
			.append( "<a>" + _.get(item, 'property_type', '') + "</a>" )
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

				var parent = $(this).closest('.popup-box');

				if ($(parent).find('.service-type').val() == 'activity') {
					var href = $(parent).find('.btn-create-activity')
																.attr('data-href');
					$(parent).find('.btn-create-activity').attr('href', href+'?city='+_.get(ui, 'item.code', ''));
				}

				return false;
			}
		})
		.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
			return $( "<li>" )
			.append( "<a>" + _.get(item, 'fullname', _.get(item, 'name', '')) + "</a>" )
			.appendTo( ul );
		};
	});


	$(document).on('keyup paste', '.client-contact', function(e) {

		if ($(this).val() != $(this).attr('data-mobile')) {
			$(this).attr('data-token', '');
		}

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
								.attr('data-token', _.get(ui, 'item.token', ''))
									.attr('data-mobile', _.get(ui, 'item.mobile', ''));
				$('.client-name').val(_.get(ui, 'item.name', ''));
				$('.client-email').val(_.get(ui, 'item.email', ''));
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