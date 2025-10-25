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
    @include('sections.customer.header')
    {{-- show messages --}}

    @if ($errors->any())
        <div>{{ $errors->first() }}</div>
    @endif

    @if (session('status'))
        <div class="">{{ session('status') }}</div>
    @endif

    @if (session('success'))
        <div class="">{{ session('success') }}</div>
    @endif

    {{-- end show messages --}}
    @yield('content')
    @include('sections.customer.footer')
    @yield('script')
</body>

</html>
