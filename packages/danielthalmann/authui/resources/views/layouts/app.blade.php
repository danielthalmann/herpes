<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('authui::layouts.head')

    <body class="">
       @yield('content')
       @yield('javascript')
    </body>
</html>
