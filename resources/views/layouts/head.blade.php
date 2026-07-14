<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if (isset($meta))
        <title>{{ $meta['title'] }}</title>
        <meta name="description" content="{{ $meta['description'] }}">
    @else
        <title>{{ config('app.name', 'Laravel') }}</title>
    @endif
    <!-- Fonts -->

    <!-- Styles / Scripts -->
    @vite(['packages/danielthalmann/herpes/resources/css/app.css', 'packages/danielthalmann/herpes/resources/js/app.ts'])
    @yield('style')
    @yield('javascript_head')
</head>
