<script>
	$(document).on('click', '.toggle-activity', function () {
		var id = $(this).attr('data-id');
		$('#'+id).toggle();
	});
</script>