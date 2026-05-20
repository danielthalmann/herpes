<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('herpes::layouts.head')

    <body class="h-full bg-gray-900 text-neutral-100">
       @yield('content')
       @yield('javascript')
    </body>
</html>
