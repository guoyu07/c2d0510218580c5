<header id="header">
	<div id="toolbar" class="grid-block">
	</div>
	<div id="headerbar" class="grid-block">
		<a id="logo" href="/">
			<img src="{{ urlImage('images/icon/FGFLOGO4.png') }}" width="140" alt="logo" />
		</a>
	</div>
	<div id="menubar" class="grid-block">
		<nav id="menu">
			<ul class="menu menu-dropdown">
				<li class="level1 active current">
					<a href="{{ $urlObj->url('home') }}" class="level1">
						<span>
							<span class="icon text-center">
								{{-- <i class="fa fa-home font-size-18"></i> --}}
							</span>trip summary
						</span>
					</a>
				</li>
				@if ($package->flightRoutes->count())
					<li class="level1 active current">
						<a href="{{ $urlObj->url('flights') }}" class="level1">
							<span>
								<span class="icon text-center">
									{{-- <i class="fa fa-plane font-size-18"></i> --}}
								</span>flights
							</span>
						</a>
					</li>
				@endif
				@if ($package->accomoRoutes->count())
					<li class="level1 active current">
						<a href="{{ $urlObj->url('accommodation') }}" class="level1">
							<span>
								<span class="icon text-center">
									{{-- <i class="fa fa-building font-size-18"></i> --}}
								</span>accommodation
							</span>
						</a>
					</li>
				@endif

				{{-- <li class="level1 active current">
					<a href="{{ $urlObj->url('itinerary') }}" class="level1">
						<span>
							<span class="icon text-center">
								<i class="fa fa-plane font-size-18"></i>
							</span>itinerary
						</span>
					</a>
				</li> --}}

				@if ($package->activityRoutes->count())
					<li class="level1 active current">
						<a href="{{ $urlObj->url('activities') }}" class="level1">
							<span>
								<span class="icon text-center">
									{{-- <i class="fa fa-futbol-o font-size-18"></i> --}}
								</span>things to do
							</span>
						</a>
					</li>
				@endif

				@if ($package->packages->where('is_locked', 1)->count() > 1)
					<li class="level1 active current">
						<a href="{{ $urlObj->url('packages') }}" class="level1">
							<span>
								<span class="icon text-center">
									{{-- <i class="fa fa-futbol-o font-size-18"></i> --}}
								</span>all packages
							</span>
						</a>
					</li>
				@endif
				
				{{-- <li class="level1 active current">
					<a href="{{ $urlObj->url('terms_and_condition') }}" class="level1">
						<span>
							<span class="icon text-center">
							</span>terms & condition
						</span>
					</a>
				</li> --}}

			</ul>
		</nav>
	</div>
</header>