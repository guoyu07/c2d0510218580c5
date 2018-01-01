<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-futbol-o"></i>
		<span>Activties</span>
		<span class="badge bg-green">{{ isset($menus->activities->count) ? $menus->activities->count : '' }}</span>
	</a>
	<ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		@if (isset($menus->activities->activitiesResult))
			@forelse( $menus->activities->activitiesResult as $menuActivities)
				@if ( isset($menuActivities->ActivitySearchResult->ActivityResults) && 
							bool_object($menuActivities->ActivitySearchResult->ActivityResults) )
					@foreach ($menuActivities->ActivitySearchResult->ActivityResults as $menuActivity)
						<li>
							<a>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h2>{{ ifset($menuActivity->ActivityData->ActivityName) }}</h2>
									</div>
								</div>
								<div class="row">
									<div class="col-md-10 col-sm-10 col-xs-12">
										<span>Date : {{ date_formatter(ifset($menuActivity->date), 'd/m/Y', 'd-M-Y') }}</span><span>Adult : {{ ifset($menuActivity->adultCount) }}</span><span> | </span><span>Child : {{ ifset($menuActivity->childCount) }}</span>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<i class="fa fa-rupee font-size-15"></i>
										<span class="font-size-15">
										{{ ceil(getInrCost([ifset($menuActivity->currency) => ifset($menuActivity->finalPrice)])) }}</span>
									</div>
								</div>
							</a>
						</li>
					@endforeach
				@else
					<li>No Activity Selected</li>
				@endif
			@empty
				<li>No Activity Selected</li>
			@endforelse

			@if (bool_array($menus->activities->activitiesResult))
				<li>
					<div class="text-center">
						<a href="{{ urlPackageAll($urlVariable->id, $urlVariable->packageDbId) }}">
							<strong>See All Hotels</strong>
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</li>
			@endif
		@else
			<li>No Activity Selected</li>
		@endif
	</ul>
</li>