@extends('errors.main')
@section('content')
	<div class="text-center">
		<h1 class="error-number">@yield('error', '404')</h1>
		<h2>@yield('subject', 'Sorry but we couldn\'t find this page')</h2>
		<p>
			@yield('message', 'This page you are looking for does not exist ')
			<a href="@yield('url', isset($url) ? $url : '#')">
				@yield('url_name', isset($url_name) ? $url_name : 'Report this?')
			</a>
		</p>
	</div>
@endsection