@extends('layouts.admin')

@section('title', 'مدیریت ویژگی‌ها')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">مدیریت ویژگی‌ها</h2>
        <a href="{{ route('attributes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            افزودن ویژگی جدید
        </a>
    </div>

    <table class="w-full border-collapse border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">#</th>
                <th class="border p-2 text-right">نام ویژگی</th>
                <th class="border p-2 text-right">نمایش در فیلتر</th>
                <th class="border p-2 text-right">تاریخ ایجاد</th>
                <th class="border p-2 text-center">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attributes as $attribute)
                <tr class="border-t">
                    <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border p-2">{{ $attribute->name }}</td>
                    <td class="border p-2">
                        @if ($attribute->filterable)
                            ✅ بله
                        @else
                            ❌ خیر
                        @endif
                    </td>
                    <td class="border p-2">{{ jdate($attribute->created_at)->format('Y/m/d') }}</td>
                    <td class="border p-2 text-center">
                        <a href="{{ route('attributes.edit', $attribute->id) }}"
                            class="text-blue-600 hover:underline">ویرایش</a>
                        <a href="{{ route('attributes.values.index', $attribute->id) }}"
                            class="bg-green-600 text-white px-2 py-1 rounded">
                            افزودن مقدار
                        </a>
                        <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('آیا از حذف این ویژگی مطمئن هستید؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline ml-2">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">هیچ ویژگی‌ای یافت نشد.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $attributes->links() }}
    </div>
@endsection
