<div class="top-user-area clearfix">
	<ul class="top-user-area-list list list-horizontal list-border">
		@if (!is_null($auth))
			<li class="top-user-area-avatar">
				<a href="{{ url('traveler') }}/user-profile.html">
					<img class="origin round" src="{{ $auth->profile_pic }}" alt="{{ $auth->fullname }}" title="AMaze" />Hi, {{ $auth->firstname }}</a>
			</li>
			<li>
				<a href="{{ url('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign Out</a>
				<form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
					{{ csrf_field() }}
				</form>
			</li>
			@include('traveler.layout.partials.user.myaccount')
		@else
			<li>
				<a href="{{ url('login-register') }}">Login / Register</a>
			</li>
		@endif
		{{-- @include('traveler.layout.partials.user.language') --}}
	</ul>
</div>