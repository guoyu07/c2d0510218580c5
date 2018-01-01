@if ($package->accomoRoutes->count())
	<article class="item">
		<header>
			<h1 class="title">
				<a href="{{ $urlObj->url('accommodation') }}" title="holiday impressions">accommodations</a>
			</h1>
		</header>
		
    @foreach ($package->accomoRoutes as $routeKey => $route)
			<div class="content clearfix">
				<?php 
					$accommodations = $route->accommodations();
				?>
				@foreach ($accommodations as $key => $accomoDetail)
					<?php
						$ukey = $accomoDetail->get('ukey', new_token());
						$images = $accomoDetail->get('images', []);
					?>
				  <div class="width-30-p height-200px pull-left m-right-10">
						<div class="gi-carousel-main">
					    <div class="GICarousel carousel-box_{{ $ukey }} GI_C_wrapper">
					      <ul class="GI_IC_items" style="{{ count($images) == 1 ? "display: block;" : ''}}">
									@foreach ($images as $image)
										<li>
											<img height="195" width="100%" class="align-left" alt="Hotel Image" src="{{ $image }}" />
										</li>
									@endforeach
					      </ul>
					    </div>
					  </div>
				  </div>
				  <div class="row">
						<h2 class="m-top-5">{{ $accomoDetail->get('name') }} {!! starRating($accomoDetail->get('star_rating')) !!} <small>({{ $route->mode_name }})</small></h2>
						<p>
							Type : {{ $accomoDetail->get('properties', collect())->pluck('property_type')->implode(' | ') }}
							{{-- <ul>
								@foreach ($packageService->packageServiceProperties->pluck('property_name')->unique() as $propertyName)
									<li>*{{ $propertyName }}</li>
								@endforeach
							</ul> --}}
						</p>
						<p>
							<div>{{ $route->start_datetime->format('d-M-Y') }} - {{ $route->end_datetime->format('d-M-Y') }}</div>
							<div>{{ $accomoDetail->get('address') }}</div>
						</p>
						<p>{{ $accomoDetail->get('description') }}</p>
				  </div>
					<script type="text/javascript">
						$('.carousel-box_{{ $ukey }}').GICarousel({arrows:true,carousel:true});
			   	</script>
				@endforeach
			</div>
	   	@if ($package->accomoRoutes->count() != ($routeKey+1))
				<hr>
			@endif
		@endforeach
	</article>
@endif
