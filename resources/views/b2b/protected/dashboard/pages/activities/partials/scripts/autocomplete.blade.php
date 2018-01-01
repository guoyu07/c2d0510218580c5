
<script>
	$(document).on('keyup paste', '#filter_search', function(e) {
		var key = e.which;

		if(key == 13){ /*the enter key code*/
			/*searchActivities();*/
		}
		else{
			var name = $(this).val();
			if (name.length > 2) {
				var route = windata.getCurrentRoute();
				/*showSpinIcon();*/
				var url = '{{ url("api/package/activities/search") }}/'+route.token+'?format=json&_token='+csrf_token;

				$(this).autocomplete({
					minLength: 0,
					source: url,
					focus: function( event, ui ) {
						$(this).val( ui.item.name );
						return false;
					},
					select: function( event, ui ) {
						$(this).val( ui.item.name )
										.attr('data-code', ui.item.code);

						windata.is_searched = true;
						$('#loging_log').hide();
						windata.setActivitiesResult(route.token, [ui.item]);
						windata.populateActivities(route.token, [ui.item]);
						return false;
					}
				})
				.autocomplete().data("ui-autocomplete")._renderItem =  function( ul, item ) {
					/*hideSpinIcon();*/
					return $( "<li>" )
					.append( "<a>" + item.name + "</a>" )
					.appendTo( ul );
				};
			}
		}
	});
</script>