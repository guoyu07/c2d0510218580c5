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
								<div class="m-top-10"></div>
								@foreach ($itinerary->body as $body)
									@foreach ($body as $key => $value)
										<h2 class="title c-title i-{{$key}}">
											<p class="excerpt sans-serif font-size-14">{!!$value!!}</p>
										</h2>
									@endforeach
								@endforeach
							</div>
						</div>
					</li>
				@endforeach
				<li class="noborder">
					<div class="block">
						<div class="tags">
							<a href="" class="tag">
								<span>Day 2</span>
							</a>
						</div>
						<div class="block_content">
							<div class="m-top-10"></div>
							<h2 class="title c-title i-car">
								<div class="byline">
									<b><a>Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a></a></b>
								</div>
							</h2>
							<h2 class="title c-title i-car">
								<a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam sit saepe et quia illo! Nesciunt accusantium dignissimos, asperiores quos, unde voluptatum maiores sed voluptate doloribus quis debitis, accusamus cupiditate deleniti.</a>
							</h2>
						</div>
					</div>
				</li>
				<li class="noborder">
					<div class="block">
						<div class="tags">
							<a href="" class="tag">
								<span>Day 3</span>
							</a>
						</div>
						<div class="block_content">
							<div class="m-top-10"></div>
							<h2 class="title c-title i-car">
								<a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
							</h2>
							<div class="byline">
								<span>13 hours ago</span> by <a>Jane Smith</a>
							</div>
							<p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
							</p>
						</div>
					</div>
				</li>
			</ul>

		</div>
	</div>
</article>

