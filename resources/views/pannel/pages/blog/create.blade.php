@extends('pannel.layouts.master')

@section('title', 'افزودن مقاله جدید')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 border-r-4 border-blue-500 pr-3">افزودن مقاله جدید</h1>

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- عنوان --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">عنوان مقاله</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400" required>
        </div>

        {{-- دسته‌بندی --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">دسته‌بندی (آرشیو)</label>
            <select name="archive_id"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400" required>
                <option value="">انتخاب دسته‌بندی</option>
                @foreach ($archives as $archive)
                    <option value="{{ $archive->id }}" {{ old('archive_id') == $archive->id ? 'selected' : '' }}>
                        {{ $archive->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- تصویر اصلی --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">تصویر اصلی مقاله</label>
            <input type="file" name="main_image" class="w-full border border-gray-300 rounded-lg p-2">
        </div>

        {{-- خلاصه --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">خلاصه کوتاه</label>
            <textarea name="summary" rows="3"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400">{{ old('summary') }}</textarea>
        </div>

        {{-- متن کامل --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">متن مقاله</label>
            <textarea name="body" rows="8"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400" required>{{ old('body') }}</textarea>
        </div>

        {{-- پین‌ها --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700">پین‌ها (تگ‌ها)</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($pins as $pin)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="pins[]" value="{{ $pin->id }}"
                            {{ in_array($pin->id, old('pins', [])) ? 'checked' : '' }}>
                        {{ $pin->name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- انتشار --}}
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_published" id="is_published" {{ old('is_published') ? 'checked' : '' }}>
            <label for="is_published">انتشار مقاله</label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('blogs.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                بازگشت
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ثبت مقاله
            </button>
        </div>
    </form>
</div>
@endsection
