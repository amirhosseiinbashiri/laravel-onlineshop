<div class="w-full py-2 pt-4">
    <div class="flex justify-between items-center">
        <a href="{{ route('home') }}"><img class="h-[30px]" src="{{ asset('/img/logo.png') }}" alt="site logo"></a>
        <div class="flex flex-row-reverse items-center gap-3">
            @include('main.components.authButton')
            <a href="{{ route('home') }}" class="text-md font-bold text-gray-700 cursor-pointer hover:text-black transition-colors duration-300">خانه</a>
            <a href="{{ route('about') }}" class="text-md font-bold text-gray-700 cursor-pointer hover:text-black transition-colors duration-300">درباره ما</a>
            <a href="{{ route('products') }}" class="text-md font-bold text-gray-700 cursor-pointer hover:text-black transition-colors duration-300">محصولات</a>
            <a href="{{ route('cart.index') }}" class="text-md font-bold text-gray-700 cursor-pointer hover:text-black transition-colors duration-300">سبد خرید</a>
        </div>
    </div>
</div>
