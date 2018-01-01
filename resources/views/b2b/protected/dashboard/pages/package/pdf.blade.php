<!DOCTYPE html>
<html>
<head>
	<title>PackageId</title>
	@include('b2b.protected.dashboard.pages.package.pdf_partials.styles')
</head>
<body>
	<div class="tile_only" style="background-image: url({{ urlImage('images/pdf/country/mix3.jpg') }});">
		<div class="height-300px"></div>
		<div class="tile_title_div">
			<div class="tile_title">Hi {{ $package->client->fullname }}</div>
		</div>
	</div>
	<div class="width-100p">
		<div class="bg-color-theme font-size-40px text-center l-height-100px">Greetings from Fly GoldFinch</div>
		<img src="{{ urlImage('images/pdf/wallpaper/6.jpg') }}" class="width-100p">
		
		{{-- your package div --}}
		<div>
			@include('b2b.protected.dashboard.pages.package.pdf_partials.info')
		</div>
		{{-- /your package div --}}

		<img src="{{ urlImage('images/pdf/country/new-zealand-wallpaper-1.jpg') }}" class="width-100p height-410px">
		<div>
			{{-- flights --}}
			@include('b2b.protected.dashboard.pages.package.pdf_partials.flights')
			{{-- /flights --}}
		</div>
		<div>
			{{-- accomodation --}}
			@include('b2b.protected.dashboard.pages.package.pdf_partials.accomo')
			{{-- /accomodation --}}
		</div>

		<div>
			{{-- accomodation --}}
			@include('b2b.protected.dashboard.pages.package.pdf_partials.cars')
			{{-- /accomodation --}}
		</div>

		<div>
			{{-- itinerary --}}
			@include('b2b.protected.dashboard.pages.package.pdf_partials.itinerary')
			{{-- /itinerary --}}
		</div>
		<div>
			{{-- Hotels And Detail --}}
			@include('b2b.protected.dashboard.pages.package.pdf_partials.hotels')
			{{-- /Hotels And Detail --}}
		</div>

		<div>
			{{-- Hotels And Detail --}}
			@include('b2b.protected.dashboard.pages.package.pdf_partials.cruises')
			{{-- /Hotels And Detail --}}
		</div>
		
		<div>
			{{-- activities --}}
			@include('b2b.protected.dashboard.pages.package.pdf_partials.activities')
			{{-- /activities --}}
		</div>

		{{-- text which is give by admin(AdminApp) --}}
		@include('b2b.protected.dashboard.pages.package.pdf_partials.texts')
		{{-- /text which is give by admin(AdminApp) --}}
		
		{{-- agent and fgf box --}}
		<div {{-- class="height-1000px" --}}>
			<br/>
			<div class="{{-- m-top-70px --}} border-theme-5px">
				<div class="agent-box">
					<div>Thanks & Best Regards</div>
					<div><b>{{ $auth->fullname }}</b></div>
					<div>
						<img src="{{ urlImage('images/pdf/phone.png') }}" width="18px"> : +91 {{ $auth->mobile }}
					</div>
					<div>
						<img src="{{ urlImage('images/pdf/email.png') }}" width="24px"> : {{ $auth->email }}
					</div>
				</div>
			</div>
			<div class="m-top-10px">
				<div class="fgf-footer-box">
					<div>D-45, Shubham Enclave, Paschim Vihar, New Delhi-110063</div>
					<div>Email: info@flygoldfinch.com | Website: www.flygoldfinch.com</div> 
				</div>
			</div>
		</div>
		{{-- /agent and fgf box --}}

	</div>
</body>
</html>

