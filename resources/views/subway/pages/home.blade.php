<!DOCTYPE HTML>
<html lang="en-US" dir="ltr">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<title>Welcome | {{ $package->uid }} {{ $package->title }}</title>
		@include('subway.pages.home_partials.head')
	</head>
	<body id="page" class="page home blog sidebar-a-right sidebar-b-right isblog wp-home wp-front_page transparency-75 system-transparent">
		@include('subway.pages.home_partials.book')
		<div id="page-body">
			<div class="page-body-1">
				<div id="socialbar">
					@include('subway.pages.home_partials.social')
				</div>
				<div class="wrapper grid-block">
					@include('subway.pages.home_partials.header')
					<div class="row">
						<div class="col-md-7 col-sm-7 col-xs-12">
							<section id="content" class="grid-block">
								<div id="system">
									<div class="items items-col-1 grid-block">
										<div class="grid-box width100">
											{{-- @include('subway.pages.home_partials.routes')	 --}}
											@include('subway.pages.trip_summary.index')	
											@include('subway.pages.home_partials.flights')	
											@include('subway.pages.home_partials.accomo')	
											@include('subway.pages.home_partials.visa')

										</div>
									</div>
								</div>
							</section>
						</div>
						<div class="col-md-5 col-sm-5 col-xs-12 subway-theme-font">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									@include('subway.pages.home_partials.pricing')
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									@include('subway.pages.home_partials.agent')
								</div>
							</div>
							<div class="row font-size-0" style="color:transparent;">
								@include('subway.pages.home_partials.slideshow')
							</div>
							<div class="row">

								<section id="content" class="grid-block m-right-n-5">
									<div id="system">
										<div class="items items-col-1 grid-block">
											<div class="grid-box width100">
												@include('subway.pages.home_partials.activities')	
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
					{{-- @include('subway.pages.home_partials.footer') --}}
				</div>
				<script type='text/javascript' src='{{ url('/') }}/subway/wp-includes/js/wp-embed.min1c9b.js?ver=4.6.1'></script>
			</div>
		</div>
		@include('subway.pages.home_partials.scripts')

	</body>
</html>