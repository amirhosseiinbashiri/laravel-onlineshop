@extends('main.layouts.master')

@section('title', 'بلاگ‌ها')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4 space-y-6">

    {{-- فیلترها --}}
    <div class="flex flex-wrap items-center gap-4 bg-white p-4 rounded-xl shadow">
        <form method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <select name="archive" onchange="this.form.submit()" class="border rounded-lg p-2">
                <option value="">همه دسته‌ها</option>
                @foreach($archives as $archive)
                    <option value="{{ $archive->slug }}" {{ request('archive') == $archive->slug ? 'selected' : '' }}>
                        {{ $archive->title }}
                    </option>
                @endforeach
            </select>

            <select name="pin" onchange="this.form.submit()" class="border rounded-lg p-2">
                <option value="">همه پین‌ها</option>
                @foreach($pins as $pin)
                    <option value="{{ $pin->slug }}" {{ request('pin') == $pin->slug ? 'selected' : '' }}>
                        {{ $pin->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- لیست بلاگ‌ها --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($blogs as $blog)
            @include('main.components.blogCart', ['blog' => $blog])
        @empty
            <p class="text-gray-500 col-span-full text-center">هیچ مقاله‌ای یافت نشد.</p>
        @endforelse
    </div>

    {{-- صفحه‌بندی --}}
    <div class="mt-8">
        {{ $blogs->withQueryString()->links() }}
    </div>

</div>
@endsection
