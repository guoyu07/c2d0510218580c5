<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://b2b.flygoldfinch.dev/common/dashboard/vendors/jquery/dist/jquery.min.js"></script>
	<script>
		$(document).ready(function () {
			var html = ''
			$('[role="button"]').each(function () {
				data = $(this).attr('data-content');
				if (data != undefined) {
					html += $(this).attr('data-content');
				}
			});
			$.ajax({
				type : "post",
				url : "{{ Request::url() }}/save",
				data : { '_token' : '{{ csrf_token() }}', 'html' : html },
				success: function(response, textStatus, xhr) {
					console.log(response);
					if (response != 'done') {
	         	document.location.href = response;
					}else{
						alert(response);
					}
        }
			});
			console.log(html);
		});
	</script>
</head>
	{!! $html !!}
	
</html>