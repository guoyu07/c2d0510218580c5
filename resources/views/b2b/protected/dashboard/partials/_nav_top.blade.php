
{{-- top navigation  --}}
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>

			<ul class="nav navbar-nav navbar-right">
				@include('b2b.protected.dashboard.partials.menu_partials.profile')
				@include('b2b.protected.dashboard.partials.menu_partials.todos')
				@include('b2b.protected.dashboard.partials.menu_partials.followups')
				@include('b2b.protected.dashboard.partials.menu_partials.track')
				@include('b2b.protected.dashboard.partials.menu_partials.leads')

				@yield('menutab')
			</ul>
		</nav>
	</div>
</div>
{{-- top navigation --}}