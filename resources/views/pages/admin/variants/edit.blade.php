@extends('layouts.admin')

@section('title', "ویرایش واریانت #{$variant->id}")

@section('content')
<h1 class="text-xl font-bold mb-4">ویرایش واریانت برای {{ $product->title }}</h1>

<form action="{{ route('products.variants.update', [$product, $variant]) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-1">کد انبار (SKU):</label>
        <input type="text" name="sku" class="w-full border rounded px-3 py-2" value="{{ old('sku', $variant->sku) }}">
    </div>

    <div>
        <label class="block mb-1">موجودی:</label>
        <input type="number" name="stock" class="w-full border rounded px-3 py-2" value="{{ old('stock', $variant->stock) }}">
    </div>

    <div>
        <label class="block mb-1">قیمت:</label>
        <input type="number" name="price" class="w-full border rounded px-3 py-2" value="{{ old('price', $variant->price) }}">
    </div>

    <div>
        <label class="block mb-1">قیمت با تخفیف:</label>
        <input type="number" name="discount_price" class="w-full border rounded px-3 py-2" value="{{ old('discount_price', $variant->discount_price) }}">
    </div>

    <div>
        <label class="block mb-1">تاریخ انقضای تخفیف:</label>
        <input type="datetime-local" name="discount_expires_at" class="w-full border rounded px-3 py-2" value="{{ old('discount_expires_at', $variant->discount_expires_at ? $variant->discount_expires_at->format('Y-m-d\TH:i') : '') }}">
    </div>

    <div>
        <label class="block mb-2 font-medium">ویژگی‌ها:</label>
        @foreach ($attributes as $attribute)
            <div class="mb-2">
                <span class="block text-sm mb-1">{{ $attribute->name }}:</span>
                <select name="attribute_values[]" class="border rounded px-2 py-1">
                    <option value="">— انتخاب کنید —</option>
                    @foreach ($attribute->values as $value)
                        <option value="{{ $value->id }}"
                            {{ in_array($value->id, $selected_values) ? 'selected' : '' }}>
                            {{ $value->value }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        ذخیره تغییرات
    </button>
</form>
@endsection
