<article class="item">
	<header>
		<h1 class="title">Itinerary</h1>
	</header>
	<div class="content clearfix p-10">
		<div class="x_content sans-serif">
			<ul class="list-unstyled timeline">
				@foreach ($package->itinerary as $itinerary)
					<li class="noborder">
						<div class="block">
							<div class="tags">
								<a href="" class="tag">
									<span>Day {{$itinerary->day}}</span>
								</a>
							</div>
							<div class="block_content">
								@if (isset($itinerary->body))
									@foreach ($itinerary->body as $body)
										@foreach ($body as $key => $value)
											<h2 class="title c-title i-{{$key}}">
												<p class="excerpt sans-serif font-size-14">
													{!!$value!!}
													@if ($key == 'activity')
														<?php 
															$activityTags = []; 
															foreach ($itinerary->activities as $activiyKey => $activity) {
																$activityTags[] = '<a class="toggle-activity btn btn-link font-light-blue nopadding nomargin" data-id="'.$activity->ukey.'" >'.$activity->name.'</a>';
															}
														?>
														{!! '('.implode(', ', $activityTags).')' !!}
													@endif
													@if ($key == 'activity')
														@foreach ($itinerary->activities as $activiyKey => $activity)
															<div id="{{ $activity->ukey }}" style="display: none;">
																<h3>{{ $activity->name }}</h3>
																<ul>
																	<li class="noborder">
																		{!! $activity->description !!}
																	</li>
																</ul>
																@if ($activiyKey != (count($itinerary->activities)-1))
																	<hr>
																@endif
															</div>
														@endforeach
													@endif
												</p>
											</h2>
										@endforeach
									@endforeach
								@endif
							</div>
						</div>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</article>

