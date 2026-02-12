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




    <div class="h-screen flex flex-row-reverse overflow-hidden bg-gray-100">

        {{-- سایدبار (ثابت در ارتفاع صفحه) --}}
        <aside class="w-64 h-screen bg-white shadow-md flex-shrink-0 h-full overflow-y-auto">
            @include('pannel.components.sidebar')
        </aside>

        {{-- بخش اصلی --}}
        <main class="flex-1 flex flex-col h-full ">
            @include('pannel.components.header')

            {{-- محتوای صفحه --}}
            <div class="p-6 flex-1 overflow-y-auto">
                @yield('content')
            </div>
        </main>

    </div>


    @yield('script')

    {{-- انیمیشن محو شدن بعد چند ثانیه --}}

</body>

</html>
