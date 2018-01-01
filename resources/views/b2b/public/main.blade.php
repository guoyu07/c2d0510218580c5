<!DOCTYPE html>
<html lang="en">
    <head>
        @include('public/partials/_head')
    </head>
    <body>

        {{-- Navigation --}}
        @include('public/partials/_nav')
    
        {{-- Main content --}}
        @yield('content')

        {{-- Footer --}}
        @include('public/partials/_footer')
        @include('public/partials/_scripts')
    </body>
</html>
