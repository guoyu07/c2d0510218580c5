{{-- Datatables --}}
<script>
	$(document).ready(function() {
		$('#datatable').dataTable({
			// "pageLength": 100
			"order": [[ 3, "desc" ]],
			"bPaginate": false
		});
	});
</script>
{{-- /Datatables --}}

{{-- autocomplete --}}
<script>
	$(document).on('keypress', '.location', function(e) {
		var url = "{{ url('destination/json') }}";
		$(this).autocomplete({ source: url });
	});
</script>
{{-- /autocomplete --}}


<script>
	$(document).on('change', '.rank', function() {
		var id = $(this).attr('data-id');
		var vendor = $(this).attr('data-vendor');
		var	url = "{{ url('/dashboard/activities') }}/"+vendor+"/"+id+'/rank';

		var data = {
			"_token" : "{{ csrf_token() }}",
			"index" : $(this).val()
		};
		console.log(data);

		$.ajax({
			type : "post",
			url : url,
			data : data,
			success : function(html) {
				console.log(html);
			}
		});
	});
</script>