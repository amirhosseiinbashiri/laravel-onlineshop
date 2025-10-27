@extends('layouts.admin')

@section('title', "واریانت‌های محصول: {$product->title}")

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-xl font-bold">واریانت‌های محصول: {{ $product->title }}</h1>
    <a href="{{ route('products.variants.create', $product) }}" class="bg-blue-600 text-white px-4 py-2 rounded">
        افزودن واریانت جدید
    </a>
</div>


<table class="min-w-full bg-white border">
    <thead>
        <tr class="bg-gray-100">
            <th class="px-4 py-2 border">شناسه</th>
            <th class="px-4 py-2 border">کد انبار (SKU)</th>
            <th class="px-4 py-2 border">ویژگی‌ها</th>
            <th class="px-4 py-2 border">موجودی</th>
            <th class="px-4 py-2 border">قیمت</th>
            <th class="px-4 py-2 border">تخفیف</th>
            <th class="px-4 py-2 border">عملیات</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($variants as $variant)
            <tr>
                <td class="px-4 py-2 border text-center">{{ $variant->id }}</td>
                <td class="px-4 py-2 border text-center">{{ $variant->sku }}</td>
                <td class="px-4 py-2 border text-center">
                    @foreach ($variant->values as $val)
                        <span class="bg-gray-200 text-sm px-2 py-1 rounded mx-1">
                            {{ $val->attribute->name }}: {{ $val->value }}
                        </span>
                    @endforeach
                </td>
                <td class="px-4 py-2 border text-center">{{ $variant->stock }}</td>
                <td class="px-4 py-2 border text-center">{{ number_format($variant->price) }} تومان</td>
                <td class="px-4 py-2 border text-center">
                    @if ($variant->discount_price)
                        {{ number_format($variant->discount_price) }} تومان
                    @else
                        —
                    @endif
                </td>
                <td class="px-4 py-2 border text-center">
                    <a href="{{ route('products.variants.edit', [$product, $variant]) }}" class="text-blue-600">ویرایش</a> |
                    <form action="{{ route('products.variants.destroy', [$product, $variant]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('حذف شود؟')">حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-gray-500">هیچ واریانتی وجود ندارد.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $variants->links() }}
</div>
@endsection
