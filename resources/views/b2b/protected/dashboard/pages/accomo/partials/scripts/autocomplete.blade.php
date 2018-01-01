<script>
	$(document).on('keyup paste', '#filter_search', function(e) {
		var name = $(this).val();
		if (name.length > 1) {
			/*showSpinIcon();*/
			var url = '{{ urlAccomoApi("search/name") }}/'+windata.current_rtoken+'?format=json&_token='+csrf_token;

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
					windata.populateAccomos(windata.current_rtoken, [ui.item]);
					/*windata.is_searched = false;*/

					/*hideSpinIcon();*/
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
	});
</script>