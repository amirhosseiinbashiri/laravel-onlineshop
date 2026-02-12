@extends('main.layouts.master')

@section('title', 'سبد خرید')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">سبد خرید شما</h2>

        @if (count($cart))
            <table class="w-full text-right border">
                <thead>
                    <tr>
                        <th class="p-2 border">محصول</th>
                        <th class="p-2 border">قیمت</th>
                        <th class="p-2 border">تعداد</th>
                        <th class="p-2 border">جمع</th>
                        <th class="p-2 border">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $id => $item)
                        <tr>
                            <td class="p-2 border flex items-center gap-2">
                                <img src="{{ asset('storage/' . $item['main_image']) }}"
                                    class="w-12 h-12 object-cover rounded">
                                {{ $item['title'] }}
                            </td>
                            <td class="p-2 border">{{ number_format($item['price']) }} تومان</td>
                            <td class="p-2 border flex items-center gap-2">
                                {{-- دکمه کاهش --}}
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <input type="hidden" name="quantity" value="{{ max($item['quantity'] - 1, 1) }}">
                                    <button type="submit" class="bg-gray-300 px-2 rounded hover:bg-gray-400">-</button>
                                </form>

                                {{-- تعداد فعلی --}}
                                <span class="px-2">{{ $item['quantity'] }}</span>

                                {{-- دکمه افزایش --}}
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                    <button type="submit" class="bg-gray-300 px-2 rounded hover:bg-gray-400">+</button>
                                </form>
                            </td>

                            <td class="p-2 border">{{ number_format($item['price'] * $item['quantity']) }} تومان</td>
                            <td class="p-2 border">
                                <form action="{{ route('cart.remove', ['product' => $id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 rounded">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3 class="text-right mt-4 text-xl font-bold">جمع کل: {{ number_format($total) }} تومان</h3>

            <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">پاک کردن
                    سبد</button>
            </form>
        @else
            <p class="text-center text-gray-500">سبد خرید شما خالی است.</p>
        @endif
    </div>

@endsection
