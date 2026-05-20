<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Daniel Thalmann (white-ermine.ch)">
    <link rel="icon" href="{{ url('/images/logo-white-sans-32x32.svg') }}" sizes="32x32" />

    @if (isset($meta))
        <title>{{ $meta['title'] }}</title>
        <meta name="description" content="{{ $meta['description'] }}">
    @else
        <title>{{ config('app.name', 'Laravel') }}</title>
    @endif
    <!-- Fonts -->

    <!-- Styles / Scripts -->
    @vite(['packages/danielthalmann/herpes/resources/css/app.css', 'packages/danielthalmann/herpes/resources/js/app.js'])
    @yield('style')
    @yield('javascript_head')
</head>
