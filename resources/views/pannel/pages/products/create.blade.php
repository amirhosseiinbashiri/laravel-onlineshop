@extends('pannel.layouts.master')

@section('title', 'افزودن محصول جدید')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-md border border-gray-100 p-6">

        {{-- 🔹 هدر --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">افزودن محصول جدید</h2>
                <p class="text-gray-500 text-sm mt-1">فرم ثبت محصول در فروشگاه</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                بازگشت
            </a>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- 🔸 مشخصات عمومی --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">مشخصات محصول</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block mb-1 font-medium">نام محصول</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block mb-1 font-medium">دسته‌بندی</label>
                        <select name="category_id" id="category_id" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">بدون دسته</option>
                            @foreach ($categories as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                @foreach ($parent->children as $child)
                                    <option value="{{ $child->id }}">— {{ $child->title }}</option>
                                    @foreach ($child->children as $sub)
                                        <option value="{{ $sub->id }}">—— {{ $sub->title }}</option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="short_description" class="block mb-1 font-medium">توضیح کوتاه</label>
                    <textarea name="short_description" id="short_description" rows="2"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">{{ old('short_description') }}</textarea>
                </div>

                <div class="mt-4">
                    <label for="description" class="block mb-1 font-medium">توضیح کامل</label>
                    <textarea name="description" id="description" rows="5"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- 🔸 قیمت و تخفیف --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">قیمت و تخفیف</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="price" class="block mb-1 font-medium">قیمت (تومان)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="discount_price" class="block mb-1 font-medium">قیمت با تخفیف</label>
                        <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price') }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="discount_ends_at" class="block mb-1 font-medium">تاریخ پایان تخفیف</label>
                        <input type="datetime-local" name="discount_ends_at" id="discount_ends_at"
                            value="{{ old('discount_ends_at') }}" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            {{-- 🔸 تگ‌ها --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">تگ‌ها (اختیاری)</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach ($tags as $tag)
                        <label class="flex items-center gap-2 text-gray-700 text-sm border border-gray-200 px-3 py-1 rounded-lg hover:bg-gray-100 cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                   {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            {{ $tag->title }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- 🔸 تصاویر --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">تصاویر محصول</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="main_image" class="block mb-1 font-medium">تصویر شاخص</label>
                        <input type="file" name="main_image" id="main_image"
                            class="border w-full p-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="images" class="block mb-1 font-medium">گالری تصاویر (اختیاری)</label>
                        <input type="file" name="images[]" id="images" multiple
                            class="border w-full p-2 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            {{-- 🔸 دکمه‌ها --}}
            <div class="flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    ➕ ثبت محصول
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
