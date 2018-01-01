@extends('public/main')
@section('title', ' | Home')
@section('content')

	<a name="home"></a>
	<div class="intro-header">
		<div class="container">

			<div class="row">
				<div class="col-lg-12">
					<div class="intro-message">
						<h1>{{ config('app.name', 'Laravel') }}</h1>
						@if(!Auth::check())
						<hr class="intro-divider">
							<div class="row">
								<div class="col-md-4 col-md-offset-4">
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
											<a href="{{ url('login') }}" class="btn btn-success btn-lg btn-block">
												<span class="network-name">Login</span>
											</a>
										</div>
										{{-- <div class="col-md-6">
											<a href="{{ url('register') }}" class="btn btn-info btn-lg btn-block">
												<span class="network-name">Register</span>
											</a>
										</div> --}}
									</div>
								</div>
							</div>
						@else
							<br/>
							<br/>
							<br/>
						@endif
					</div>
				</div>
			</div>

		</div>
		{{-- /.container --}}

	</div>
	{{-- /.intro-header --}}

	{{-- Page Content --}}

	<a  name="services"></a>
	<div class="content-section-a">

		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-sm-6">
					<hr class="section-heading-spacer">
					<div class="clearfix"></div>
					<h2 class="section-heading">Build your package and get instantly</h2>
					<p class="lead">
						Taking too much time to making package because of collecting information from muiltiple places. 
						<br/> Just 
						<a target="_blank" href="{{ url('/login') }}">try new app
						</a>
						which gives you freedom to make your package at one place with lots of feature.
					</p>
				</div>
				<div class="col-lg-5 col-lg-offset-2 col-sm-6">
					<img class="img-responsive" src="{{ URL::asset('public/img/dashboard.jpg') }}" alt="">
				</div>
			</div>

		</div>
		{{-- /.container --}}

	</div>
	{{-- /.content-section-a --}}

	<div class="content-section-b">

		<div class="container">

			<div class="row">
				<div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
					<hr class="section-heading-spacer">
					<div class="clearfix"></div>
					<h2 class="section-heading">Customize your package</h2>
					<p class="lead"> 
						<ul>
							<li>Map your route</li>
							<li>Search Hotel</li>
							<li>Choose your favorite car</li>
							<li>Select your desire activity</li>
							<li>Arrange itinerary as your wish</li>
						</ul>
					</p>
				</div>
				<div class="col-lg-5 col-sm-pull-6  col-sm-6">
					<img class="img-responsive" src="{{ URL::asset('public/img/Customize.jpg') }}" alt="">
				</div>
			</div>

		</div>
		{{-- /.container --}}

	</div>
	{{-- /.content-section-b --}}

	<div class="content-section-a">

		<div class="container">

			<div class="row">
				<div class="col-lg-5 col-sm-6">
					<hr class="section-heading-spacer">
					<div class="clearfix"></div>
					<h2 class="section-heading">Beautiful layouts in just one PDF</h2>
					<p class="lead">
						Get your desire package with amazing layout in just one PDF
					</p>
				</div>
				<div class="col-lg-5 col-lg-offset-2 col-sm-6">
					<img class="img-responsive" src="{{ URL::asset('public/img/pdf_gray.jpg') }}" alt="">
				</div>
			</div>

		</div>
		{{-- /.container --}}

	</div>
	{{-- /.content-section-a --}}
	
	<a name="about"></a>
	<div class="content-section-b">

		<div class="container">

			<div class="row">
				<div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
					<hr class="section-heading-spacer">
					<div class="clearfix"></div>
					<h2 class="section-heading">About Us</h2>
					<p class="lead"> 
						Seitan blog aesthetic, tousled cronut portland vegan biodiesel retro tattooed distillery tacos ugh bushwick. Heirloom slow-carb literally, disrupt vape intelligentsia jean shorts copper mug aesthetic waistcoat. Williamsburg farm-to-table bushwick fanny pack, synth cray coloring book offal sartorial typewriter chicharrones. Offal tattooed franzen, retro fixie dreamcatcher marfa readymade thundercats fingerstache gluten-free food truck tote bag brunch air plant. Marfa meditation pok pok vice, chillwave normcore woke swag brooklyn cardigan health goth ugh yuccie. Ramps disrupt jean shorts lo-fi small batch readymade. Mustache jean shorts YOLO deep v subway tile.
						Meh yr stumptown, meditation yuccie drinking vinegar affogato succulents YOLO. Messenger bag green juice cardigan mumblecore jean shorts thundercats.

					</p>
				</div>
				<div class="col-lg-5 col-sm-pull-6  col-sm-6">
					<img class="img-responsive" src="{{ URL::asset('public/img/about.png') }}" alt="">
				</div>
			</div>

		</div>
		{{-- /.container --}}

	</div>

	<a  name="contact"></a>
	<div class="banner">

		<div class="container">

			<div class="row">
				<div class="col-lg-6">
					<h2>Connect to FlyGoldfinch:</h2>
				</div>
				<div class="col-lg-6">
					<ul class="list-inline banner-social-buttons">
						<li>
							<a href="https://twitter.com/FlyGoldfinch" class="btn btn-default btn-lg">
								<i class="fa fa-twitter fa-fw"></i> 
								<span class="network-name">Twitter</span>
							</a>
						</li>
						<li>
							<a href="https://facebook.com/FlyGoldfinch" class="btn btn-default btn-lg">
								<i class="fa fa-facebook fa-fw"></i> 
								<span class="network-name">Facebook</span>
							</a>
						</li>
						<li>
							<a href="#" class="btn btn-default btn-lg">
								<i class="fa fa-google-plus fa-fw"></i> 
								<span class="network-name">Goolge+</span>
							</a>
						</li>
					</ul>
				</div>
			</div>

		</div>
		{{-- /.container --}}

	</div>
	{{-- /.banner --}}
@endsection()