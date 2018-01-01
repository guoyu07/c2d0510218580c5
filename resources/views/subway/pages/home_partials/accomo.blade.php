@if ($package->accomoRoutes->count())
	<article class="item">
		<header>
			<h1 class="title">
				<a href="{{ $urlObj->url('accommodation') }}" title="holiday impressions">accommodations</a>
			</h1>
		</header>
		
		<div class="gi-carousel-main">
			<div class="GICarousel carousel-box-accommo GI_C_wrapper">
				<ul class="GI_IC_items" style="{{ $package->accomoRoutes->count() == 1 ? "display: block;" : ''}}">
					@foreach ($package->accomoRoutes as $key => $route)
						<?php
							$accomoDetails = $route->accommodations();
						?>
						@foreach ($accomoDetails as $accomoDetail)
							<li>
								{{-- @if (!is_null($accomoDetail->get('name)) --}}
									<div class="content clearfix">
										<img height="195" width="195" class="align-left" alt="{{ $accomoDetail->get('name') }}" src="{{ $accomoDetail->get('image') }}" />
										<h2 class="m-top-5">{{ $accomoDetail->get('name') }} {!! starRating($accomoDetail->get('star_rating')) !!} <small>({{ $route->mode }})</small></h2>
										<p>
											Property Type : {{ $accomoDetail->get('properties', collect())->pluck('property_type')->implode(' | ') }}
										</p>
										<p>
											<div>{{ $route->start_datetime->format('d-M-Y') }} - {{ $route->end_datetime->format('d-M-Y') }}</div>
											<div>{{ $accomoDetail->get('address') }}</div>
										</p>
										{{-- <p>{{ sub_string($accomoDetail->get('description'), 120) }}</p> --}}
									</div>
								{{-- @else
									<div class="content clearfix">
										<h3>Something is wrong. please contact your agent.</h3>
									</div>
								@endif --}}
							</li>
						@endforeach
					@endforeach
				</ul>
			</div>
		</div>
		<script type="text/javascript">
			$('.carousel-box-accommo').GICarousel({arrows:true,carousel:true});
		</script>
	</article>
	<div class="links">
		<a href="{{ $urlObj->url('accommodation') }}" title="show more">show more</a>
	</div>
@endif
