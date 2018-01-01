<!DOCTYPE html>
<html lang="en">
    <head>
        @include('b2b.partials._head')
    </head>
    <body>

        {{-- Navigation --}}
        @include('b2b.partials._nav')
    
        {{-- Main content --}}
        @yield('content')

        {{-- Footer --}}
        @include('b2b.partials._footer')
        @include('b2b.partials._scripts')
    </body>
</html>
