@extends('layouts.admin')

@section('title', 'افزودن ویژگی جدید')

@section('content')
    <h2 class="text-xl font-bold mb-4">افزودن ویژگی جدید</h2>

    <form method="POST" action="{{ route('attributes.store') }}" class="max-w-lg">
        @csrf

        <div class="mb-3">
            <label for="name" class="block mb-1">نام ویژگی</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border rounded p-2">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3 flex items-center gap-2">
            <input type="checkbox" name="filterable" id="filterable" value="1"
                   {{ old('filterable') ? 'checked' : '' }}>
            <label for="filterable">نمایش در فیلتر محصولات</label>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ذخیره ویژگی
        </button>
        <a href="{{ route('attributes.index') }}" class="ml-3 text-gray-600 hover:underline">بازگشت</a>
    </form>
@endsection
