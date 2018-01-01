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
				
				{{-- {{dd($auth)}} --}}
				<img src="{{ $auth->profile_pic }}" alt="..." class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<div class="text-center">Welcome!</div>
				<h2 class="text-center">{{ $auth->fullname }}</h2>
				<h2 class="text-center">
					<div class="font-size-17">({{ $auth->companyname }})</div>
				</h2>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="text-right font-white">
				<div><b>Valid Till</b>: {{ isset($auth->package->end_date) ? $auth->package->end_date->format('d-m-Y') : ''}}</div>
				<div>
					<b>Active Plan :</b>
					<span class="font-{{ isset($auth->package->plan->name) ? $auth->package->plan->name : ''}}">{{ isset($auth->package->plan->name) ? $auth->package->plan->name : ''}}</span>
					<a href="{{ route('showPlans') }}" class="btn-success btn-xs font-size-11" target="_blank">Plans</a>
				</div>

				<div>
					<span>
						<b>Balance (
							<i class="fa fa-rupee font-size-11"></i> 
							<span>{{ $auth->balance }}</span>)
						</b> 
					</span>
					<a href="{{ route('addMoney') }}" class="btn-danger btn-xs" target="_blank">Add Money</a>
				</div>
			</div>
			<div class="m-top-20"></div>
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
							<li><a href="{{ url('dashboard/enquiry/create') }}">New Enquiry</a></li>
							<li><a href="{{ url('dashboard/enquiry') }}">All Enquiry</a></li>
						</ul>
					</li>
					<li>
						<a><i class="fa fa-desktop"></i> Admin Console <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="{{ url('dashboard/console/manage/users') }}">Users</a></li>
							<li class="hide"><a href="{{ url('dashboard/settings/text/create') }}"></a></li>
							{{-- <li><a href="{{ url('dashboard/settings/vendor/lead') }}">Reports</a></li> --}}
						</ul>
					</li>
					
					<li>
						<a><i class="fa fa-hdd-o"></i> Inventories <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="{{ url('dashboard/inventories/activity/location') }}">Activity</a></li>
						</ul>
					</li>

					<li>
						<a><i class="fa fa-cog"></i> Settings <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="{{ url('dashboard/settings/text') }}">Information & Text</a></li>
							<li class="hide"><a href="{{ url('dashboard/settings/text/create') }}"></a></li>
							<li><a href="{{ url('dashboard/settings/vendor/lead') }}">Lead Vendor</a></li>
						</ul>
					</li>
				</ul>
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