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
		<h2>Payment Gateway Testing Sample</h2>
		<table>
			<tr>
				<td>Transaction Id</td>
				<td><strong>{{ $txnid }}</strong></td>
				<td>Amount: </td>
				<td><strong>{{ $amount }}</strong></td>
			</tr>
		</table>
			<div >
				{{-- <p>In this page we will genrate hash and send it to payumoney.</p> --}}
				<br>
				<p>Please be patient. this process might take some time,<br />please do not hit refresh or browser back button or close this window</p>
			</div>
		</div>

		<div>
			<form name="postForm" action="{{ $url }}" method="POST" >
				<input type="hidden" name="key" value="{{ $key }}" />
				<input type="hidden" name="hash" value="{{ $hash }}"/>
				<input type="hidden" name="txnid" value="{{ $txnid }}" />
				<input type="hidden" name="amount" value="{{ $amount }}" />
				<input type="hidden" name="firstname" value="{{ $name }}" />
				<input type="hidden" name="email" value="{{ $email }}" />
				<input type="hidden" name="phone" value="{{ $phone }}" />
				<input type="hidden" name="productinfo" value="{{ $productinfo }}" />
				<input type="hidden" name="service_provider" value="payu_paisa" size="64" />
				<input type="hidden" name="surl" value="{{ $surl }}" />
				<input type="hidden" name="furl" value="{{ $furl }}" />
			</form>
		</div>
	</body>
</html>