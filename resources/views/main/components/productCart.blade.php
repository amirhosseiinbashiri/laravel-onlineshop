<div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-3 group">

    {{-- تصویر محصول --}}
    <a href="{{ route('product', $product->slug) }}" class="block relative overflow-hidden rounded-xl">
        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->title }}"
            class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">

        @if ($product->discount_price)
            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">
                تخفیف ویژه
            </span>
        @endif
    </a>

    {{-- اطلاعات محصول --}}
    <div class="mt-3 space-y-2">
        {{-- عنوان --}}
        <h3 class="text-gray-800 font-semibold text-lg line-clamp-1">
            <a href="{{ route('product', $product->slug) }}" class="hover:text-blue-600">
                {{ $product->title }}
            </a>
        </h3>

        {{-- قیمت --}}
        <div class="flex items-center gap-2">
            @if ($product->discount_price)
                <span class="text-gray-400 line-through text-sm">{{ number_format($product->price) }} تومان</span>
                <span class="text-red-600 font-bold">{{ number_format($product->discount_price) }} تومان</span>
            @else
                <span class="text-blue-600 font-bold">{{ number_format($product->price) }} تومان</span>
            @endif
        </div>

        @php
            $cart = session('cart', []);
            $inCart = isset($cart[$product->id]);
        @endphp

        @if (!$inCart)
            {{-- دکمه افزودن --}}
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="block text-center w-full bg-blue-600 text-white py-2 rounded-xl hover:bg-blue-700 transition font-semibold">
                    افزودن به سبد خرید
                </button>
            </form>
        @else
            {{-- دکمه حذف --}}
            <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="block text-center w-full bg-red-500 text-white py-2 rounded-xl hover:bg-red-600 transition font-semibold">
                    حذف از سبد خرید
                </button>
            </form>
        @endif

    </div>
</div>
