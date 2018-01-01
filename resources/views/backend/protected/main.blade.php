<!DOCTYPE html>
<html lang="en">
    <head>
        @include('admin.partials._head')
    </head>
    <body>

        {{-- Navigation --}}
        @include('admin.partials._nav')
    
        {{-- Main content --}}
        @yield('content')

        {{-- Footer --}}
        @include('admin.partials._footer')
        @include('admin.partials._scripts')
    </body>
</html>
