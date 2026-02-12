<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('meta')
    @yield('style')
    <title>Shop | @yield('title')</title>
</head>

<body>
    @include('components.alerts')

    @yield('content')
    @yield('script')
</body>

</html>
