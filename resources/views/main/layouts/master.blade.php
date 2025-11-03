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
    <div class="min-h-screen max-w-[1260px] mx-auto">
        @include('main.components.header')
        @include('main.components.categories')
        @yield('content')
    </div>
    @include('main.components.footer') 
    @yield('script')
</body>

</html>
