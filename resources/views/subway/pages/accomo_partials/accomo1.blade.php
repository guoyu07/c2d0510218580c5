@if ($package->accomoRoutes->count())
	<article class="item">
		<header>
			<h1 class="title">
				<a href="{{ $urlObj->url('accommodation') }}" title="holiday impressions">accommodations</a>
			</h1>
		</header>
		
    @foreach ($package->accomoRoutes as $key => $route)
			<div class="content clearfix">
			  @if (!is_null($route->accomo()->name))
					<?php
						$images = $route->fusion->images();
						$accomo = $route->accomo();
						$images[] = $accomo->image;
						$images = array_unique($images);
					?>
				  <div class="width-30-p height-200px pull-left m-right-10">
						<div class="gi-carousel-main">
					    <div class="GICarousel carousel-box{{$key}} GI_C_wrapper">
					      <ul class="GI_IC_items" style="{{ $package->accomoRoutes->count() == 1 ? "display: block;" : ''}}">
									@foreach ($images as $image)
										<li>
											<img height="195" width="100%" class="align-left" alt="Hotel Image" src="{{ $image }}" />
										</li>
									@endforeach
					      </ul>
					    </div>
					  </div>
				  </div>
				  <div class="">
						<h2 class="m-top-5">{{ $accomo->name }} {!! $accomo->starRatingHtml !!} <small>({{$route->mode}})</small></h2>
						<p>
							<div>{{ $accomo->startDate }} - {{ $accomo->endDate }}</div>
							<div>{{ $accomo->location }}</div>
						</p>
						<p>{{ $accomo->description }}</p>
				  </div>
				@else
					<h3>Something is wrong. please contact your agent.</h3>
				@endif

			</div>
			<script type="text/javascript">
				$('.carousel-box{{$key}}').GICarousel({arrows:true,carousel:true});
	   	</script>
	   	@if ($package->accomoRoutes->count() != ($key+1))
				<hr>
			@endif
		@endforeach
	</article>
@endif
