<article class="item m-top-10">
	<header>
		<h1 class="title">
			<a>visa detail</a>
		</h1>
	</header>
	<div class="gi-carousel-main height-300px">
		<div class="GICarousel visa carousel-box GI_C_wrapper">
			<ul class="GI_IC_items height-100p scroll-auto scroll-bar" style="{{ $package->accomoRoutes->count() == 1 ? "display: block;" : ''}}">
				<?php $done = []; ?>
				@foreach ($package->accomoRoutes as $key => $route)
					<?php $visaDetail = $route->visaDetail(); ?>
					@if (!is_null($visaDetail) && !in_array($visaDetail->country, $done))
						<?php $done[] = $visaDetail->country; ?>
						<li>
							<div class="content clearfix">
								{{-- <img height="195" width="195" class="align-left" alt="{{ $accomo->name }}" src="{{ $accomo->image }}" /> --}}
								<h2 class="m-top-5"><b>{!! $visaDetail->country !!} VISA</b></h2>
								<p>
									<div>{!! $visaDetail->contacts !!}</div>
								</p>
								<p>{!! $visaDetail->details !!}</p>
							</div>
						</li>
					@endif
				@endforeach
			</ul>
		</div>
	</div>
	<script type="text/javascript">
		$('.visa.carousel-box').GICarousel({arrows:true,carousel:true});
	</script>
</article>