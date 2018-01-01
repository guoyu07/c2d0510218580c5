<!DOCTYPE HTML>
<html class="full">


<!-- Mirrored from remtsoy.com/tf_templates/traveler/demo_v1_7/loading.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Aug 2017 21:37:01 GMT -->
<head>
	@include('traveler.layout.partials._head')
</head>

<body class="full">

	<!-- FACEBOOK WIDGET -->
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<!-- /FACEBOOK WIDGET -->
	<div class="global-wrap">
		<div class="demo_changer" id="demo_changer">
			<div class="demo-icon fa fa-sliders"></div>
			<div class="form_holder">
				<div class="line"></div>
				<p>Color Scheme</p>
				<div class="predefined_styles" id="styleswitch_area">
					<a class="styleswitch" href="{{ url('traveler') }}/loadingc392.html?default=true" style="background:#ED8323;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/bright-turquoise" style="background:#0EBCF2;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/turkish-rose" style="background:#B66672;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/salem" style="background:#12A641;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/hippie-blue" style="background:#4F96B6;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/mandy" style="background:#E45E66;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/green-smoke" style="background:#96AA66;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/horizon" style="background:#5B84AA;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/cerise" style="background:#CA2AC6;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/brick-red" style="background:#cf315a;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/de-york" style="background:#74C683;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/shamrock" style="background:#30BBB1;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/studio" style="background:#7646B8;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/leather" style="background:#966650;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/denim" style="background:#1A5AE4;"></a>
					<a class="styleswitch" href="{{ url('traveler') }}/#" data-src="{{ url('traveler') }}/scarlet" style="background:#FF1D13;"></a>
				</div>
				<div class="line"></div>
				<p>Layout</p>
				<div class="predefined_styles"><a class="btn btn-sm" href="{{ url('traveler') }}/#" id="btn-wide">Wide</a><a class="btn btn-sm" href="{{ url('traveler') }}/#" id="btn-boxed">Boxed</a>
				</div>
				<div class="line"></div>
				<p>Background Patterns</p>
				<div class="predefined_styles" id="patternswitch_area">
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/binding_light.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/binding_dark.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/dark_fish_skin.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/dimension.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/escheresque_ste.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/food.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/giftly.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/grey_wash_wall.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/ps_neutral.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/pw_maze_black.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/pw_pattern.png);"></a>
					<a class="patternswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/patterns/simple_dashed.png);"></a>
				</div>
				<div class="line"></div>
				<p>Background Images</p>
				<div class="predefined_styles" id="bgimageswitch_area">
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/bike.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/bike.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/flowers.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/flowers.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/wood.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/wood.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/taxi.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/taxi.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/phone.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/phone.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/road.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/road.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/keyboard.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/keyboard.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/beach.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/beach.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/street.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/street.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/nature.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/nature.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/bridge.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/bridge.jpg"></a>
					<a class="bgimageswitch" href="{{ url('traveler') }}/#" style="background-image: url(img/switcher/cameras.jpg);" data-src="{{ url('traveler') }}/img/backgrounds/cameras.jpg"></a>
				</div>
				<div class="line"></div>
			</div>
		</div>
		<div class="full-page">
			<div class="bg-holder full">
				<div class="bg-mask"></div>
				<div class="bg-img" style="background-image:url(img/upper_lake_in_new_york_central_park_1024x487.jpg);"></div>
				<div class="bg-holder-content full text-white text-center">
					<a class="logo-holder" href="{{ url('traveler') }}/index-2.html">
						<img src="{{ url('traveler') }}/img/logo-white.png" alt="Image Alternative text" title="Image Title" />
					</a>
					<div class="full-center">
						<div class="container">
							<div class="spinner-clock">
								<div class="spinner-clock-hour"></div>
								<div class="spinner-clock-minute"></div>
							</div>
							<h2 class="mb5">Looking for hotels in New York City...</h2>
							<p class="text-bigger">it will take a couple of seconds</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('traveler.layout.partials._scripts')
</body>


<!-- Mirrored from remtsoy.com/tf_templates/traveler/demo_v1_7/loading.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Aug 2017 21:37:14 GMT -->
</html>



