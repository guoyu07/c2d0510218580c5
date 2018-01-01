
{{--  Left bar --}}
<div class="col-md-3 left_col menu_fixed">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="{{ url('dashboard') }}" class="site_title">
				<i class="s-icon-fgf"></i> 
				<span> Dashboard</span>
			</a>
		</div>

		<div class="clearfix"></div>

		{{--  menu profile quick info --}}
		<div class="profile">
			<div class="profile_pic">
				<img src="{{ $auth->profile_pic }}" alt="..." class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Welcome,</span>
				<h2>{{ $auth->fullname }}</h2>
			</div>
		</div>
		{{--  /menu profile quick info --}}

		<br />

		{{--  sidebar menu --}}
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
			<div class="menu_section">
				<div class="row"></div>
				<ul class="nav side-menu">
					<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li class="hide"><a href="{{ url('dashboard') }}">Dashboard</a></li>
							<li><a href="{{ url('dashboard/enquiry/create') }}">New Enquiry</a></li>
							<li><a href="{{ url('dashboard/package/all') }}">All Packages</a></li>
							<li><a href="{{ url('dashboard/enquiry') }}">Client List</a></li>
							<li><a href="{{ url('dashboard/follow-up') }}">Follow Up</a></li>
						</ul>
					</li>
					<li><a><i class="fa fa-cogs"></i> Tools <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
								<li class="hide"><a href="{{ url('dashboard/tools') }}">Tools</a></li>
							<li><a href="{{ url('dashboard/tools/calendar') }}">Calendar</a></li>
							<li><a href="{{ url('dashboard/tools/contacts') }}">Contact List</a></li>
							{{-- <li><a href="{{ url('dashboard/tools/invoice') }}">Invoice</a></li>
							<li><a href="{{ url('dashboard/tools/inbox') }}">Inbox</a></li>
							<li><a href="{{ url('dashboard/tools/vouchers') }}">Vouchers</a></li> --}}
						</ul>
					</li>
					<li><a><i class="fa fa-desktop"></i> Monitoring<span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<?php 
								$pageNames = [
										// "client" => "Client",
										"packages" => "Track Packages",
										// "lead" => "Leads",
										// "follow-up" => "Follow Ups" ,
										// "growth-chart" => "Growth Chart",
									];
							?>
							@foreach ($pageNames as $pageNameKey => $pageName)
								<li>
									<a href="{{ url('dashboard/monitoring/'.$pageNameKey) }}">
										{{ $pageName }}
									</a>
								</li>
							@endforeach
						</ul>
					</li>
					{{-- <li><a><i class="fa fa-bar-chart-o"></i>Activities<span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="{{ url('activity-report') }}">Activity Reports</a></li>
							<li><a href="{{ url('performance') }}">Your Performance</a></li>
							<li><a href="{{ url('activity-report') }}">Activity Reports</a></li>
						</ul>
					</li> --}}
				</ul>
			</div>

		</div>
		{{--  /sidebar menu --}}

		{{--  /menu footer buttons --}}
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
		{{--  /menu footer buttons --}}
	</div>
</div>
{{--  /left end here --}}