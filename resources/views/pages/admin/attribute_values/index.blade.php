@extends('layouts.admin')

@section('title', 'مقادیر ویژگی ' . $attribute->name)

@section('content')
    <h2>مدیریت مقادیر ویژگی "{{ $attribute->name }}"</h2>

    <a href="{{ route('attributes.values.create', $attribute->id) }}"
       class="bg-blue-600 text-white px-3 py-1 rounded inline-block mb-3">
        افزودن مقدار جدید
    </a>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-right">#</th>
                <th class="p-2 text-right">مقدار</th>
                <th class="p-2 text-right">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($values as $value)
                <tr class="border-t">
                    <td class="p-2">{{ $value->id }}</td>
                    <td class="p-2">{{ $value->value }}</td>
                    <td class="p-2">
                        <a href="{{ route('attributes.values.edit', [$attribute->id, $value->id]) }}"
                           class="text-blue-600">ویرایش</a> |
                        <form action="{{ route('attributes.values.destroy', [$attribute->id, $value->id]) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600"
                                onclick="return confirm('حذف شود؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
