<!DOCTYPE html>
<html>
<head>
	<title>Payment Processing</title>
	<script>
		function submitForm() {
			var postForm = document.forms.postForm;
			postForm.submit();
		}
	</script>
</head>
<body onload="submitForm();">
	<div>
		<div>
			<form name="postForm" action="{{ $url }}" method="POST" >
				<input type="hidden" name="payuid" value="{{ $payuid }}" />
			</form>
		</div>
	</body>
</html>