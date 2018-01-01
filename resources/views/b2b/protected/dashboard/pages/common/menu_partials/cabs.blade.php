<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-car"></i>
		<span>Cabs</span>
		<span class="badge bg-green">{{ ifset($menus->cabs->count) }}</span>
	</a>
	<ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		@if (ifset($menus->cabs->cabsResult))
			
			@forelse( $menus->cabs->cabsResult as $booked_Cabs)
				<li>
					<a>
						<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
							<h2>{{ ifset($booked_Cabs->CabName) }}</h2>
						</div>
						<div>
							<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
								<div class="col-md-5 col-sm-5 col-xs-12 nopadding">
									{{ ifset($booked_Cabs->origin) }}
								</div>
								<div class="col-md-5 col-sm-5 col-xs-12 nopadding">
									{{ ifset($booked_Cabs->destination) }}
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12 nopadding text-right">
									<i class="fa fa-rupee font-size-15"></i>
									<span class="font-size-15">{{ ifset($booked_Cabs->Price) }}</span>
								</div>
							</div>
						</div>
					</a>
				</li>
			@empty
				<li>No Cabs</li>
			@endforelse

			@if (bool_array($menus->cabs->cabsResult))
				<li>
					<div class="text-center">
						<a href="{{  urlPackageAll($urlVariable->id, $urlVariable->packageDbId) }}">
							<strong>See All Cabs</strong>
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</li>
			@endif
			
		@else
			<li>No Cabs</li>
		@endif
	</ul>
</li>