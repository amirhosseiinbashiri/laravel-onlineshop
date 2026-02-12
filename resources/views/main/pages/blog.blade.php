@extends('main.layouts.master')

@section('title', $blog->title)

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 space-y-8">

    <div class="text-center space-y-3">
        <h1 class="text-3xl font-bold text-gray-800">{{ $blog->title }}</h1>
        <div class="text-sm text-gray-500 flex justify-center gap-4">
            <span>{{ jdate($blog->created_at)->format('Y/m/d') }}</span>
            <span>دسته: {{ $blog->archive->title ?? 'بدون دسته' }}</span>
        </div>
    </div>

    @if($blog->main_image)
        <div class="rounded-xl overflow-hidden shadow">
            <img src="{{ asset('storage/' . $blog->main_image) }}" alt="{{ $blog->title }}" class="w-full">
        </div>
    @endif

    <div class="prose prose-gray text-justify leading-relaxed">
        {!! nl2br(e($blog->body)) !!}
    </div>

    {{-- پین‌ها --}}
    @if($blog->pins->count())
        <div class="flex flex-wrap gap-2 mt-6">
            @foreach($blog->pins as $pin)
                <a href="{{ route('blogs', ['pin' => $pin->slug]) }}"
                   class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full hover:bg-blue-100 hover:text-blue-700 transition">
                   #{{ $pin->name }}
                </a>
            @endforeach
        </div>
    @endif

    {{-- مقالات مرتبط --}}
    @if($relatedBlogs->count())
        <div class="mt-10 border-t pt-6">
            <h3 class="text-xl font-semibold mb-4">مطالب مرتبط</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedBlogs as $related)
                    @include('main.components.blogCart', ['blog' => $related])
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
