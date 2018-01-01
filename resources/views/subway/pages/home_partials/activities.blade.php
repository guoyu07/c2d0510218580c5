@if ($package->activities->count())
	<article class="item">
		<header>
			<h1 class="title">
				<a href="{{ $urlObj->url('accommodation') }}" title="holiday impressions">things to do</a>
			</h1>
		</header>
		<?php 
			$allActivities = $package->activities->chunk(3);
		?>
		
		<div class="gi-carousel-main height-250px">
	    <div class="GICarousel carousel-box-things-to-do GI_C_wrapper">
	      <ul class="GI_IC_items height-250px" style="{{ $allActivities->count() == 1 ? "display: block;" : ''}}">
		      @foreach ($allActivities as $activities)
						<li class="height-250px">
		     		 @foreach ($activities as $activity)
								<div class="content clearfix m-top-10">
									<img height="70" width="80" class="align-left" alt="{{ $activity->get('name') }}" src="{{ $activity->get('image') }}" />
									<div class="font-size-17"><b><i>{{$activity->get('name')}}</i></b></div>
									<div>{{ sub_string(strip_tags($activity->get('description')), 120) }}</div>
								</div>
							@endforeach
						</li>
					@endforeach
	      </ul>
	    </div>
	  </div>
	  @if ($allActivities->count() != 1)
			<script type="text/javascript">
				$('.carousel-box-things-to-do').GICarousel({ arrows:true,carousel:true });
	  	</script>
	  @endif
	</article>
	<div class="links">
		<a href="{{ $urlObj->url('activities') }}" title="show more">show more</a>
	</div>
@endif
