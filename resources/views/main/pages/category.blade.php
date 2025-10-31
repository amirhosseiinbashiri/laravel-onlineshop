@extends('main.layouts.master')

@section('title', $category->title)

@section('content')
<div class="max-w-5xl mx-auto py-6">

    {{-- عنوان دسته --}}
    <h1 class="text-2xl font-bold mb-4">{{ $category->title }}</h1>

    {{-- تصویر شاخص --}}
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}"
             alt="{{ $category->title }}"
             class="w-full max-h-64 object-cover rounded mb-4">
    @endif

    {{-- توضیح --}}
    @if ($category->description)
        <p class="text-gray-600 leading-relaxed mb-6">{{ $category->description }}</p>
    @endif

    {{-- زیر‌دسته‌ها --}}
    @if ($category->children->count())
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-3">زیر‌دسته‌ها</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($category->children as $child)
                    <a href="{{ route('category', $child->slug) }}"
                       class="border rounded-lg p-3 text-center hover:bg-gray-50 transition">
                        @if ($child->image)
                            <img src="{{ asset('storage/' . $child->image) }}"
                                 alt="{{ $child->title }}"
                                 class="w-full h-24 object-cover rounded mb-2">
                        @endif
                        <p class="font-medium">{{ $child->title }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- محصولات --}}
    <div>
        <h2 class="text-lg font-semibold mb-3">محصولات این دسته</h2>
        <div class="text-gray-500">
            (در آینده محصولات در اینجا نمایش داده می‌شوند)
        </div>
    </div>

</div>
@endsection
