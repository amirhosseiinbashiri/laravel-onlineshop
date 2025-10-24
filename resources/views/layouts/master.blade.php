<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('meta')
    @yield('style')

    <title>Shop | @yield('title')</title>
</head>
<body>
    @include('sections.header')
    @yield('content')
    @include('sections.footer')
    @yield('script')
</body>
</html>
