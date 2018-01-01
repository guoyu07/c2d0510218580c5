<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
	<div class="container topnav">
		{{-- Brand and toggle get grouped for better mobile display --}}
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand topnav" href="#">{{ config('app.name', 'Laravel') }}</a>
		</div>
		{{-- Collect the nav links, forms, and other content for toggling --}}
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="#about">About</a>
				</li>
				<li>
					<a href="#services">Services</a>
				</li>
				<li>
					<a href="#contact">Contact</a>
				</li>
				@if(Auth::check())
				<li>
					<a href="{{ url('/dashboard') }}">Dashboard</a>
				</li>
				<li>
					<a href="{{ url('/logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
          	Logout
      		</a>
					<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
				</li>
				@else
				<li>
					<a href="/login">Login</a>
				</li>
				@endif
			</ul>
		</div>
		{{-- /.navbar-collapse --}}
	</div>
	{{-- /.container --}}
</nav>  