@extends('pannel.layouts.master')

@section('title', 'ویرایش تگ')

@section('content')
<div class="min-h-screen bg-gray-50 p-6 flex justify-center">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 w-full max-w-3xl">

        {{-- عنوان --}}
        <div class="flex items-center justify-between mb-8 border-b pb-3">
            <h2 class="text-2xl font-bold text-gray-800">ویرایش نگ</h2>
            <a href="{{ route('tags.index') }}"
               class="text-sm text-blue-600 hover:text-blue-800 transition">← بازگشت به لیست</a>
        </div>

        {{-- فرم --}}
        <form method="POST" action="{{ route('tags.update', $tag->id) }}"class="space-y-5">
            @csrf
            @method('PUT')

            {{-- عنوان دسته --}}
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-1">عنوان تگ</label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $tag->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- دکمه‌ها --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('tags.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold transition">
                    انصراف
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                    ذخیره تغییرات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
