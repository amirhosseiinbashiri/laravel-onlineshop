@extends('layouts.admin')

@section('title', 'ایجاد محصول جدید')

@section('content')
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-xl font-semibold mb-6">افزودن محصول جدید</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">عنوان محصول *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded p-2">
                @error('title')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">توضیحات</label>
                <textarea name="description" class="w-full border rounded p-2" rows="5">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1">دسته‌ها</label>
                <select name="categories[]" class="w-full border rounded p-2" multiple>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">نوع محصول</label>
                <select name="type" class="w-full border rounded p-2">
                        <option value="simple">ساده</option>
                        <option value="varianted">متغیر</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="block mb-1">کد انبار داری</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="w-full border rounded p-2">
                </div>


                <div>
                    <label class="block mb-1">قیمت</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price') }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block mb-1">موجودی</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="w-full border rounded p-2">
                </div>


            </div>

            <div class="mb-4">
                <label class="block mb-1">تصویر شاخص</label>
                <input type="file" name="image" class="border rounded p-2 w-full">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-1">وضعیت</label>
                    <select name="status" class="w-full border rounded p-2">
                        <option value="draft">پیش‌نویس</option>
                        <option value="published">منتشر شده</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-300 rounded">انصراف</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">ذخیره محصول</button>
            </div>
        </form>
    </div>
@endsection
