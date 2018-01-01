@if ($package->activities->count())
	<article class="item">
		<header>
			<h1 class="title">
				<a href="{{ $urlObj->url('activities') }}" title="holiday impressions">things to do</a>
			</h1>
		</header>
	</article>
  @foreach ($package->activities as $key => $activityData)
		<?php
			$images = [];
			$activity = $activityData->activityObject(['images']);
			$images = $activity->images;
		?>
		<article class="item">
			<div class="content clearfix">
			  <div class="width-30-p height-200px pull-left m-right-10">
					<div class="gi-carousel-main">
				    <div class="GICarousel carousel-box{{$key}} GI_C_wrapper">
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
			  <div>
					<h2 class="m-top-5">{{ $activity->name }}</h2>
					<p>
						<div>
							<span>{{ $activity->date }} | </span>
							<span>{{ activityMode($activity->mode) }} | </span>
							<span>{{ activityTiming($activity->timing)}} </span>
						</div>
					</p>
					<div>{!! $activity->description !!}</div>
			  </div>
			</div>
		</article>
		<script type="text/javascript">
			$('.carousel-box{{$key}}').GICarousel({arrows:true,carousel:true});
		</script>
	@endforeach
@endif
