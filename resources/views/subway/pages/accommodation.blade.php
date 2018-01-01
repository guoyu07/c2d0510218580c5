<!DOCTYPE HTML>
<html lang="en-US" dir="ltr">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<title>Accommodation | {{ $package->uid }} {{ $package->title }}</title>
		@include('subway.pages.home_partials.head')
	</head>
	<body id="page" class="page home blog sidebar-a-right sidebar-b-right isblog wp-home wp-front_page transparency-75 system-transparent">
		<div id="page-body">
			<div class="page-body-1">
				<div id="socialbar">
					@include('subway.pages.home_partials.social')
				</div>
				<div class="wrapper grid-block">
					@include('subway.pages.home_partials.header')
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<section id="content" class="grid-block">
								<div id="system">
									<div class="items items-col-1 grid-block">
										<div class="grid-box width100">
											@include('subway.pages.accomo_partials.accomo2')	
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
				<script type='text/javascript' src='{{ url('/') }}/subway/wp-includes/js/wp-embed.min1c9b.js?ver=4.6.1'></script>
			</div>
		</div>
	</body>
</html>