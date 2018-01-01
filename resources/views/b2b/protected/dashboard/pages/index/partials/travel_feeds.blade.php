<div class="col-md-6 col-sm-6 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Travel Feeds</h2>
			<ul class="nav navbar-right panel_toolbox panel_toolbox1">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content pre-scrollable scroll-bar" >
			<div class="dashboard-widget-content">

				<ul class="list-unstyled timeline widget">
					@foreach ($travelFeeds->channel->item as $travelFeed)
						<li>
							<div class="block">
								<div class="block_content">
									<h2 class="title">
										<a>{{ $travelFeed->title }}</a>
									</h2>
									<p class="excerpt">
										{!! html_entity_decode($travelFeed->description) !!}...
										<a href="{{ $travelFeed->link }}" class="btn-link" target="_blank">More</a>
									</p>
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>