<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
{{-- Meta, title, CSS, favicons, etc. --}}
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ config('app.backend_name', 'Trawish') }} @yield('title') </title>

<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >

{{-- Bootstrap --}}
<link href="{{ asset('admin/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
{{-- Font Awesome --}}
<link href="{{ asset('admin/dashboard/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
{{-- NProgress --}}
<link href="{{ asset('admin/dashboard/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
{{-- iCheck --}}
<link href="{{ asset('admin/dashboard/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
{{-- bootstrap-progressbar --}}
<link href="{{ asset('admin/dashboard/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">

@yield('css')

{{-- Custom Theme Style --}}
<link href="{{ asset('admin/dashboard/build/css/custom.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/icon.css') }}" rel="stylesheet">

