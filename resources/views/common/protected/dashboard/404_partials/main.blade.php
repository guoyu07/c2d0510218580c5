<!DOCTYPE html>
<html lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	{{-- Meta, title, CSS, favicons, etc. --}}
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{{ config('app.name', 'Laravel') }} @yield('title') </title>

	{{-- Bootstrap --}}
	<link href="{{ asset('common/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('common/dashboard/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('common/dashboard/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
	@yield('css')

	@yield('customCss')
	</head>

	<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-12 col-sm-12 col-xsm-12">
				<div class="col-middle">
					@yield('content')
				</div>
			</div>
		</div>
	</div>

	@yield('jquery', '<script src="'.asset('common/dashboard/vendors/jquery/dist/jquery.min.js').'"></script>')

	{{-- FastClick --}}
	<script src="{{ asset('common/dashboard/vendors/fastclick/lib/fastclick.js') }}"></script>
	<script src="{{ asset('common/dashboard/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('common/dashboard/vendors/nprogress/nprogress.js') }}"></script>
	@yield('js')
	{{-- Custom Theme Scripts --}}
	<script src="{{ asset('common/dashboard/build/js/custom.min.js') }}"></script>

	@yield('scripts')

	</body>
</html>
