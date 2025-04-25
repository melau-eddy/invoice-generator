<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('layouts.shared.headSection')
    @yield('CssSection')
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
</head>
<body>
@include('layouts.shared.header')
@yield('body')
@yield('JsSection')
</body>
</html>
