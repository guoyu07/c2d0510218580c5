<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="refresh" content="5400">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('app_name', config('app.name', 'Trawish')) @yield('title') </title>

<link rel="shortcut icon" href="{{ asset('favicon.png') }}" >

{{-- Bootstrap --}}
<link href="{{ commonAsset('dashboard/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
{{-- Font Awesome --}}
<link href="{{ commonAsset('dashboard/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

{{-- NProgress --}}
<link href="{{ commonAsset('dashboard/vendors/nprogress/nprogress.css') }}" rel="stylesheet">

{{-- Animate.css --}}
<link href="{{ commonAsset('dashboard/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

<link href="{{ commonAsset('dashboard/build/css/custom.min.css') }}" rel="stylesheet">
{{-- Custom Theme Style --}}
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/icon.css') }}" rel="stylesheet">
