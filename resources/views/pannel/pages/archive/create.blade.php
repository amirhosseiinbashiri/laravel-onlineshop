@extends('pannel.layouts.master')

@section('title', 'افزودن دسته‌بندی جدید')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-right border-r-4 border-blue-400 pr-3">افزودن دسته جدید</h1>

    <form action="{{ route('archives.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="title" class="block font-medium text-gray-700 mb-1">عنوان دسته‌بندی</label>
            <input type="text" name="title" id="title"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400"
                   value="{{ old('title') }}" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('archives.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">بازگشت</a>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">ثبت دسته‌بندی</button>
        </div>
    </form>
</div>
@endsection
