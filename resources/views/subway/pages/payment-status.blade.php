<!DOCTYPE HTML>
<html>


<!-- Mirrored from remtsoy.com/tf_templates/traveler/demo_v1_7/success-payment.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Aug 2017 21:29:52 GMT -->
<head>
	<title>Traveler - Success payment</title>


	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta name="keywords" content="Template, html, premium, themeforest" />
	<meta name="description" content="Traveler - Premium template for travel companies">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- GOOGLE FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
	<!-- /GOOGLE FONTS -->
	<link rel="stylesheet" href="{{ url('traveler') }}/css/bootstrap.css">
	<link rel="stylesheet" href="{{ url('traveler') }}/css/font-awesome.css">
	<link rel="stylesheet" href="{{ url('traveler') }}/css/icomoon.css">
	<link rel="stylesheet" href="{{ url('traveler') }}/css/styles.css">
	<link rel="stylesheet" href="{{ url('traveler') }}/css/mystyles.css">
</head>

<body>
	<div class="global-wrap">
		<div class="gap"></div>
		<div class="gap"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<i class="fa fa-{{ $is_success ? 'check' : 'times' }} round box-icon-large box-icon-center box-icon-{{ $is_success ? 'success' : 'un' }} mb30"></i>  
					<h2 class="text-center">{{ $name }}, your payment was {{ $is_success ? 'successful' : 'unsuccessful' }}!</h2>
					<h5 class="text-center mb30">Details has been send to {{$email}}</h5>
					<ul class="order-payment-list list mb30">
						<li>
							<div class="row">
								<div class="col-xs-6">
									<h5>Transaction id : </h5>
								</div>
								<div class="col-xs-6">
									<p class="text-right">
										{{ $txnid }}
									</p>
								</div>
							</div>
						</li>
					</ul>
					<ul class="list list-inline list-center">
						<li>
							<a class="btn btn-primary" href="{{ $redirect_to }}"><i class="fa fa-arrow-left"></i> Back to Package</a>
						</li>
					</ul>
					{{-- <h6 class="text-center">You will be redirected in 5 seconds</h6> --}}
				</div>
			</div>
			<div class="gap"></div>
		</div>
		<script src="{{ url('traveler') }}/js/jquery.js"></script>
	</div>
	{{-- <script>
		$(document).ready(function () {
			setTimeout(function () {
				document.location.href = "{{ $redirect_to }}"
			}, 10000);
		});
	</script> --}}
</body>
</html>



