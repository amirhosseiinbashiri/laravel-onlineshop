@extends('layouts.admin')

@section('title', 'محصولات')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">لیست محصولات</h1>
        <a href="{{ route('products.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            افزودن محصول جدید
        </a>
    </div>

    <table class="w-full text-sm border">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="p-2 text-right">#</th>
                <th class="p-2 text-right">تصویر</th>
                <th class="p-2 text-right">عنوان</th>
                <th class="p-2 text-right">قیمت</th>
                <th class="p-2 text-right">وضعیت</th>
                <th class="p-2 text-right">دسته‌ها</th>
                <th class="p-2 text-right">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $product->id }}</td>
                    <td class="p-2">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-12 h-12 rounded object-cover" style="width: 25px">
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="p-2">{{ $product->title }}</td>
                    <td class="p-2">{{ number_format($product->price, 0) }} تومان</td>
                    <td class="p-2">
                        @if($product->status === 'published')
                            <span class="text-green-600">منتشر شده</span>
                        @else
                            <span class="text-gray-500">پیش‌نویس</span>
                        @endif
                    </td>
                    <td class="p-2">
                        @foreach($product->categories as $cat)
                            <span class="text-xs bg-gray-200 rounded px-2 py-1">{{ $cat->title }}</span>
                        @endforeach
                    </td>
                    <td class="p-2">
                        <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">ویرایش</a>
                        <a href="{{ route('products.variants.create', $product->id) }}" class="text-blue-600 hover:underline">افزودن ویژگی</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline" onclick="return confirm('حذف شود؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="p-4 text-center text-gray-500">هیچ محصولی ثبت نشده است.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
