@extends('pannel.layouts.master')

@section('title', 'مشاهده مقاله')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow max-w-4xl mx-auto space-y-6">

    {{-- عنوان مقاله --}}
    <div class="border-b pb-4">
        <h1 class="text-3xl font-bold text-gray-800">{{ $blog->title }}</h1>
        <div class="text-sm text-gray-500 mt-1 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span>نویسنده:</span>
                <span class="font-medium">{{ $blog->author->name ?? 'نامشخص' }}</span>
            </div>
            <div>
                <span class="text-gray-400">تاریخ:</span>
                <span>{{ jdate($blog->created_at)->format('Y/m/d') }}</span>
            </div>
        </div>
    </div>

    {{-- تصویر اصلی --}}
    @if ($blog->main_image)
        <div class="rounded-xl overflow-hidden shadow">
            <img src="{{ asset('storage/' . $blog->main_image) }}" alt="{{ $blog->title }}" class="w-full object-cover">
        </div>
    @endif

    {{-- خلاصه --}}
    @if ($blog->summary)
        <div class="bg-gray-50 p-4 rounded-lg text-gray-700 leading-relaxed border-r-4 border-blue-500">
            {{ $blog->summary }}
        </div>
    @endif

    {{-- متن کامل --}}
    <div class="prose prose-gray max-w-none leading-relaxed text-gray-800">
        {!! nl2br(e($blog->body)) !!}
    </div>

    {{-- دسته‌بندی و پین‌ها --}}
    <div class="flex flex-wrap items-center gap-4 mt-6 text-sm">
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
            📂 {{ $blog->archive->title ?? 'بدون دسته‌بندی' }}
        </span>

        @if ($blog->pins->count())
            <div class="flex flex-wrap gap-2">
                @foreach ($blog->pins as $pin)
                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full">#{{ $pin->name }}</span>
                @endforeach
            </div>
        @endif
    </div>

    {{-- وضعیت انتشار --}}
    <div class="mt-6">
        @if ($blog->is_published)
            <span class="inline-block bg-green-100 text-green-700 px-4 py-1 rounded-full">منتشر شده</span>
        @else
            <span class="inline-block bg-gray-100 text-gray-600 px-4 py-1 rounded-full">پیش‌نویس</span>
        @endif
    </div>

    {{-- دکمه‌ها --}}
    <div class="flex justify-end gap-3 mt-6">
        <a href="{{ route('blogs.edit', $blog) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            ویرایش مقاله
        </a>
        <a href="{{ route('blogs.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            بازگشت
        </a>
    </div>
</div>
@endsection
