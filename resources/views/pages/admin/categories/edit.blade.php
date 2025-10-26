@extends('layouts.admin')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
    <h2>ویرایش دسته‌بندی</h2>

    <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- عنوان دسته --}}
        <div class="mb-3">
            <label for="title" class="block mb-1">عنوان دسته</label>
            <input type="text" name="title" id="title" value="{{ old('title', $category->title) }}"
                class="w-full border rounded p-2">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- والد --}}
        <div class="mb-3">
            <label for="parent_id" class="block mb-1">دسته والد (اختیاری)</label>
            <select name="parent_id" id="parent_id" class="w-full border rounded p-2">
                <option value="">بدون والد</option>
                @foreach ($parents as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == $category->parent_id ? 'selected' : '' }}>
                        {{ $cat->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- آیکون --}}
        <div class="mb-3">
            <label for="icon" class="block mb-1">آیکون (اختیاری)</label>
            <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}"
                class="w-full border rounded p-2" placeholder="مثلاً fa-solid fa-phone">
        </div>

        {{-- تصویر شاخص --}}
        <div class="mb-3">
            <label for="image" class="block mb-1">تصویر شاخص</label>

            @if ($category->image)
                <div class="mb-2 flex items-center gap-3">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image"
                        class="w-20 h-20 object-cover rounded border">

                    {{-- دکمه حذف تصویر --}}
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remove_image" value="1" class="w-4 h-4">
                        <span>حذف تصویر فعلی</span>
                    </label>
                </div>
            @endif

            <input type="file" name="image" id="image" class="w-full border rounded p-2">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        {{-- توضیح --}}
        <div class="mb-3">
            <label for="description" class="block mb-1">توضیحات (اختیاری)</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded p-2">{{ old('description', $category->description) }}</textarea>
        </div>

        {{-- دکمه‌ها --}}
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">ذخیره تغییرات</button>
            <a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">بازگشت</a>
        </div>
    </form>
@endsection
