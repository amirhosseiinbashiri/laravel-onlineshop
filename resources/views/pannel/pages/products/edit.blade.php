@extends('pannel.layouts.master')

@section('title', 'ویرایش محصول')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-md border border-gray-100 p-6">

        {{-- 🔹 هدر --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">ویرایش محصول</h2>
                <p class="text-gray-500 text-sm mt-1">در حال ویرایش: {{ $product->title }}</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                بازگشت
            </a>
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- 🔸 مشخصات عمومی --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">مشخصات عمومی</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block mb-1 font-medium">نام محصول</label>
                        <input type="text" name="title" id="title"
                            value="{{ old('title', $product->title) }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block mb-1 font-medium">دسته‌بندی</label>
                        <select name="category_id" id="category_id"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">بدون دسته</option>
                            @foreach ($categories as $parent)
                                <option value="{{ $parent->id }}" {{ $product->category_id == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->title }}
                                </option>
                                @foreach ($parent->children as $child)
                                    <option value="{{ $child->id }}" {{ $product->category_id == $child->id ? 'selected' : '' }}>
                                        — {{ $child->title }}
                                    </option>
                                    @foreach ($child->children as $sub)
                                        <option value="{{ $sub->id }}" {{ $product->category_id == $sub->id ? 'selected' : '' }}>
                                            —— {{ $sub->title }}
                                        </option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="short_description" class="block mb-1 font-medium">توضیح کوتاه</label>
                    <textarea name="short_description" id="short_description" rows="2"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <div class="mt-4">
                    <label for="description" class="block mb-1 font-medium">توضیح کامل</label>
                    <textarea name="description" id="description" rows="5"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            {{-- 🔸 قیمت و تخفیف --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">قیمت و تخفیف</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="price" class="block mb-1 font-medium">قیمت (تومان)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="discount_price" class="block mb-1 font-medium">قیمت با تخفیف</label>
                        <input type="number" name="discount_price" id="discount_price"
                            value="{{ old('discount_price', $product->discount_price) }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="discount_ends_at" class="block mb-1 font-medium">تاریخ پایان تخفیف</label>
                        <input type="datetime-local" name="discount_ends_at" id="discount_ends_at"
                            value="{{ old('discount_ends_at', $product->discount_ends_at ? $product->discount_ends_at->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            {{-- 🔸 تگ‌ها --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">تگ‌ها</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach ($tags as $tag)
                        <label class="flex items-center gap-2 text-gray-700 text-sm border border-gray-200 px-3 py-1 rounded-lg hover:bg-gray-100 cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                   {{ in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                            {{ $tag->title }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- 🔸 تصاویر --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">مدیریت تصاویر</h3>

                {{-- تصویر شاخص --}}
                <div class="mb-5">
                    <label class="block mb-2 font-medium">تصویر شاخص</label>
                    @if ($product->main_image)
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ asset('storage/' . $product->main_image) }}" class="w-24 h-24 object-cover rounded-lg border">
                            <label class="flex items-center gap-2 text-red-600">
                                <input type="checkbox" name="remove_main_image" value="1"> حذف تصویر فعلی
                            </label>
                        </div>
                    @endif
                    <input type="file" name="main_image" class="border w-full p-2 rounded-lg">
                </div>

                {{-- گالری تصاویر --}}
                <div>
                    <label class="block mb-2 font-medium">گالری تصاویر</label>
                    <div class="flex flex-wrap gap-3 mb-3">
                        @foreach ($product->images as $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image->path) }}" class="w-20 h-20 object-cover rounded-lg border">
                                <label class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1 cursor-pointer">
                                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="hidden">
                                    ×
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <input type="file" name="images[]" multiple class="border w-full p-2 rounded-lg">
                </div>
            </div>

            {{-- 🔸 دکمه‌ها --}}
            <div class="flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    💾 ذخیره تغییرات
                </button>
                <a href="{{ route('products.index') }}"
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                    بازگشت
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
