@extends('main.layouts.master')

@section('title', 'محصولات')

@section('content')
    <div class="container mx-auto mt-10 px-4" dir="rtl">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

            {{-- فیلتر سمت راست --}}
            <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow">

                <form action="{{ route('products') }}" method="GET" class="space-y-6 bg-white p-6 rounded-2xl shadow-md">

                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">فیلتر محصولات</h2>

                    {{-- سرچ --}}
                    <div>
                        <label for="search" class="block text-gray-700 font-medium mb-1">جستجو</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="عنوان محصول...">
                    </div>

                    {{-- دسته بندی --}}
                    <div>
                        <label for="category" class="block text-gray-700 font-medium mb-1">دسته‌بندی</label>
                        <select name="category" id="category"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">همه دسته‌ها</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                                @foreach ($category->children as $child)
                                    <option value="{{ $child->id }}"
                                        {{ request('category') == $child->id ? 'selected' : '' }}>
                                        └ {{ $child->title }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    {{-- محدوده قیمت --}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">محدوده قیمت (تومان)</label>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" placeholder="حداقل" value="{{ request('min_price') }}"
                                class="w-1/2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <input type="number" name="max_price" placeholder="حداکثر" value="{{ request('max_price') }}"
                                class="w-1/2 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>

                    {{-- دکمه‌ها --}}
                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold text-center">
                            اعمال فیلتر
                        </button>
                        <a href="{{ route('products') }}"
                            class="flex-1 text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition font-semibold">
                            بازنشانی
                        </a>
                    </div>

                </form>

            </div>

            {{-- محصولات سمت چپ --}}
            <div class="lg:col-span-3">
                @if ($products->count())
                    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                        @foreach ($products as $product)
                            @include('main.components.productCart')
                        @endforeach
                    </div>

                    {{-- pagination --}}
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @else
                    <p class="text-gray-500 text-center text-lg mt-10">هیچ محصولی یافت نشد.</p>
                @endif
            </div>

        </div>
    </div>
@endsection
