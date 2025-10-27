@extends('layouts.admin')

@section('title', "افزودن واریانت برای {$product->title}")

@section('content')
<h1 class="text-xl font-bold mb-4">افزودن واریانت برای {{ $product->title }}</h1>

<form action="{{ route('products.variants.store', $product) }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block mb-1">کد انبار (SKU):</label>
        <input type="text" name="sku" class="w-full border rounded px-3 py-2" value="{{ old('sku') }}">
        @error('sku') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block mb-1">موجودی:</label>
        <input type="number" name="stock" class="w-full border rounded px-3 py-2" value="{{ old('stock') }}">
        @error('stock') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block mb-1">قیمت:</label>
        <input type="number" name="price" class="w-full border rounded px-3 py-2" value="{{ old('price') }}">
    </div>

    <div>
        <label class="block mb-1">قیمت با تخفیف:</label>
        <input type="number" name="discount_price" class="w-full border rounded px-3 py-2" value="{{ old('discount_price') }}">
    </div>

    <div>
        <label class="block mb-1">تاریخ انقضای تخفیف (اختیاری):</label>
        <input type="datetime-local" name="discount_expires_at" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block mb-2 font-medium">ویژگی‌ها:</label>
        @foreach ($attributes as $attribute)
            <div class="mb-2">
                <span class="block text-sm mb-1">{{ $attribute->name }}:</span>
                <select name="attribute_values[]" class="border rounded px-2 py-1">
                    <option value="">— انتخاب کنید —</option>
                    @foreach ($attribute->values as $value)
                        <option value="{{ $value->id }}">{{ $value->value }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
        @error('attribute_values') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        ثبت واریانت
    </button>
</form>
@endsection
