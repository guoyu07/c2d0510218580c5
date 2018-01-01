{{-- top navigation --}}
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>

			<ul class="nav navbar-nav navbar-right">
				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="{{ $agent->profile_pic }}" alt="">{{ $agent->fullname }}
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
						<li><a href="{{ url('dashboard/profile') }}"> Profile</a></li>
						<li><a href="{{ url('dashboard/settings') }}">Settings</a></li>
						<li>
							<a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
											{{ csrf_field() }}
									</form>
									Log Out
								<i class="fa fa-sign-out pull-right"></i>
							</a>
						</li>
					</ul>
				</li>
				
				<?php $menufollowUps = followUps(); ?>
				
				<li role="presentation" class="dropdown">
					<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-bell"></i>
						<span class="badge bg-green">{{ count($menufollowUps) }}</span>
					</a>
					
					<ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
						<li><h2>Follow-Ups</h2></li>
						@foreach ($menufollowUps as $menufollowUp)
						<li>
							<a href="{{ urlPackageAll(ifset($menufollowUp->client_id), ifset($menufollowUp->packageId)) }}">
								<span>
									<span>
										<b class="font-size-15">{{ ifset($menufollowUp->fullname) }}</b> ({{ getPackageId(ifset($menufollowUp->packageId)) }})</span>
									<span class="time">{{ ifset($menufollowUp->datetime) }}</span>
								</span>
								<span class="message">
									{{ sub_string(ifset($menufollowUp->note))}}
								</span>
							</a>
						</li>
						@endforeach
						<li>
							<div class="text-center">
								<a href="{{ url('dashboard/follow-up') }}">
									<strong>See All Follow-Ups</strong>
									<i class="fa fa-angle-right"></i>
								</a>
							</div>
						</li>
					</ul>
				</li>
				@yield('menutab')
			</ul>
		</nav>
	</div>
</div>
{{-- /top navigation --}}