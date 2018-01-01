<li class="">
	<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> 
		<img src="{{ $auth->profile_pic }}" alt="">{{ $auth->fullname }}
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