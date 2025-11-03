@extends('main.layouts.master')

@section('title', $category->title)

@section('content')
    <div class="container mx-auto px-6 py-12">

        {{-- هدر دسته --}}
        <div
            class="flex flex-col md:flex-row justify-between items-start gap-10 bg-gradient-to-l from-blue-50 to-white rounded-3xl shadow-md p-8">

            {{-- اطلاعات دسته --}}
            <div class="md:w-2/3 flex flex-col justify-center items-end text-right">
                <h1 class="text-4xl font-extrabold mb-3 text-gray-800 tracking-tight">
                    {{ $category->title }}
                </h1>

                @if ($category->description)
                    <p class="text-gray-600 leading-relaxed border-r-4 border-blue-400 pr-4 py-3 text-lg">
                        {{ $category->description }}
                    </p>
                @endif

                {{-- زیر‌دسته‌ها --}}
                @if ($category->children->count())
                    <div class="mt-6 text-right">
                        <p class="text-sm font-semibold text-gray-500 mb-2">زیر‌دسته‌ها:</p>
                        <div class="flex flex-wrap gap-2 justify-end">
                            @foreach ($category->children as $child)
                                <a href="{{ route('category', $child->slug) }}"
                                    class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium text-sm px-3 py-1 rounded-full transition">
                                    {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- تصویر دسته --}}
            @if ($category->image)
                <div class="md:w-1/3 flex justify-center">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->title }}"
                        class="rounded-2xl shadow-lg w-full max-w-sm object-cover border border-gray-200">
                </div>
            @endif
        </div>

        {{-- محصولات --}}
        <div class="mt-14" dir="rtl">
            <div class="flex justify-between items-center mb-6 mr-3">
                <h2 class="text-2xl font-bold text-gray-800 border-r-4 border-blue-400 pr-3">
                    محصولات این دسته
                </h2>
                <span class="text-gray-500 text-sm">({{ $products->count() }} محصول)</span>
            </div>

            @if ($products->count())
                <div
                    class="mt-3 grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 justify-items-end">
                    @foreach ($products as $product)
                        @include('main.components.productCart')
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center mt-10 text-lg">
                    🛍 هنوز محصولی در این دسته وجود ندارد.
                </p>
            @endif
        </div>

    </div>
@endsection
