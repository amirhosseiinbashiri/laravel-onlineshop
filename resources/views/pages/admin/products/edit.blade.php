@extends('layouts.admin')

@section('title', 'ویرایش محصول')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-xl font-semibold mb-6">ویرایش محصول: {{ $product->title }}</h1>

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">عنوان محصول *</label>
            <input type="text" name="title" value="{{ old('title', $product->title) }}" class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1">توضیحات</label>
            <textarea name="description" class="w-full border rounded p-2" rows="5">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">دسته‌ها</label>
            <select name="categories[]" class="w-full border rounded p-2" multiple>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($product->categories->contains($cat->id))>
                        {{ $cat->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1">کد انبار داری</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">قیمت</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">موجودی</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded p-2">
            </div>
        </div>

        <div class="mb-4">
            <label class="block mb-1">تصویر شاخص جدید</label>
            <input type="file" name="image" class="border rounded p-2 w-full">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="w-32 mt-2 rounded">
            @endif
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1">وضعیت</label>
                <select name="status" class="w-full border rounded p-2">
                    <option value="draft" @selected($product->status === 'draft')>پیش‌نویس</option>
                    <option value="published" @selected($product->status === 'published')>منتشر شده</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-300 rounded">انصراف</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">به‌روزرسانی</button>
        </div>
    </form>
</div>
@endsection
