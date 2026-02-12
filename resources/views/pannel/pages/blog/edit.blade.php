@extends('pannel.layouts.master')

@section('title', 'ویرایش مقاله')

@section('content')

<div class="p-6 bg-white rounded-2xl shadow max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 border-r-4 border-yellow-400 pr-3">ویرایش مقاله</h1>

    <form action="{{ route('blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- عنوان --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">عنوان مقاله</label>
            <input type="text" name="title" value="{{ old('title', $blog->title) }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400" required>
        </div>

        {{-- دسته‌بندی --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">دسته‌بندی (آرشیو)</label>
            <select name="archive_id"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400" required>
                @foreach ($archives as $archive)
                    <option value="{{ $archive->id }}" {{ $blog->archive_id == $archive->id ? 'selected' : '' }}>
                        {{ $archive->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- تصویر اصلی --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">تصویر اصلی</label>
            @if ($blog->main_image)
                <img src="{{ asset('storage/' . $blog->main_image) }}" class="w-32 h-32 object-cover rounded mb-2">
            @endif
            <input type="file" name="main_image" class="w-full border border-gray-300 rounded-lg p-2">
        </div>

        {{-- خلاصه --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">خلاصه</label>
            <textarea name="summary" rows="3"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400">{{ old('summary', $blog->summary) }}</textarea>
        </div>

        {{-- بدنه --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">متن مقاله</label>
            <textarea name="body" rows="8"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400" required>{{ old('body', $blog->body) }}</textarea>
        </div>

        {{-- پین‌ها --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">پین‌ها</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($pins as $pin)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="pins[]" value="{{ $pin->id }}"
                            {{ in_array($pin->id, old('pins', $blog->pins->pluck('id')->toArray())) ? 'checked' : '' }}>
                        {{ $pin->name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- انتشار --}}
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_published" id="is_published"
                   {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
            <label for="is_published">انتشار مقاله</label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('blogs.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                بازگشت
            </a>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                ذخیره تغییرات
            </button>
        </div>
    </form>
</div>
@endsection
