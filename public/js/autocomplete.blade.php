<script>
	$(document).on('keyup paste', '.input-airport', function(){
		$(this).autocomplete({
			minLength: 0,
			source: "{{ route("airport.names") }}",
			focus: function( event, ui ) {
				$(this).val( ui.item.fullname );
				return false;
			},
			select: function( event, ui ) {
				$(this).val( ui.item.fullname );
				$(this).attr('data-code', ui.item.airport_code);
				return false;
			}
		})
		.autocomplete()
		.data("ui-autocomplete")._renderItem =  function( ul, item ) {
			 return $( "<li>" )
			 .append( "<a>" + item.fullname+"</a>" )
			 .appendTo( ul );
		 };
	});
</script>