
{{-- Left bar --}}
<div class="col-md-3 left_col menu_fixed">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="{{ url('dashboard') }}" class="site_title">
				<i class="s-icon-fgf"></i> 
				<span>Dashboard</span>
			</a>
		</div>

		<div class="clearfix"></div>

		{{-- menu profile quick info --}}
		<div class="profile">
			<div class="profile_pic">
				
				<img src="{{ $auth->profile_pic }}" alt="..." class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Welcome,</span>
				<h2>{{ $auth->fullname }}</h2>
			</div>
		</div>
		{{-- /menu profile quick info --}}

		<br />

		{{-- sidebar menu --}}
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<div class="menu_section">
				<div class="row"></div>
				<ul class="nav side-menu">
					<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li class="hide"><a href="{{ url('dashboard') }}">Dashboard</a></li>
							{{-- <li><a href="{{ url('dashboard/activities/create') }}">New Activity</a></li>
							<li><a href="{{ url('dashboard/activities') }}">Activities List</a></li> --}}
						</ul>
					</li>
				</ul>
				<ul class="nav side-menu">
					<li><a><i class="fa fa-file-text-o"></i> Inventory <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li>
								<a href="{{ url('dashboard/manage/images') }}">
									Images
								</a>
							</li>
							<li>
								<a href="{{ url('dashboard/manage/location/country') }}">
									Countries
								</a>
							</li>
							<li>
								<a href="{{ url('dashboard/manage/location/destination') }}">
									Destinations
								</a>
							</li>
						</ul>
					</li>
				</ul>
				
				@if ($auth->type == 'su')
					<ul class="nav side-menu">
						<li><a><i class="fa fa-desktop"></i> Admin <span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
								<li class="hide">
									<a href="{{ url('admin') }}">Users</a>
								</li>
								<li>
									<a href="{{ url('admin/manage/users') }}">Users</a>
								</li>
							</ul>
						</li>
					</ul>
				@endif
			</div>

		</div>
		{{-- /sidebar menu --}}

		{{-- /menu footer buttons --}}
		<div class="sidebar-footer hidden-small">
			<a href="{{ url('dashboard/settings') }}" data-toggle="tooltip" data-placement="top" title="Settings">
				<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
			</a>
			<a href="{{ url('dashboard/profile') }}" data-toggle="tooltip" data-placement="top" title="Profile">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
			</a>
			<a data-toggle="tooltip" data-placement="top" title="Lock">
				<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
			</a>
			<a data-toggle="tooltip" data-placement="top" title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				<span class="glyphicon glyphicon-off" aria-hidden="true">
					<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
					</form>
				</span>
			</a>
		</div>
		{{-- /menu footer buttons --}}
	</div>
</div>
{{-- /left end here --}}