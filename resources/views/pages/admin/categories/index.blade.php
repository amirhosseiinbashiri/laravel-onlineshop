@extends('layouts.admin')

@section('title', 'مدیریت دسته‌ها')


@section('content')
    <h2>دسته‌بندی‌ها</h2>
    <a href="{{ route('categories.create') }}">ایجاد دسته جدید</a>

    <table>
        <thead>
            <tr>
                <th>عنوان</th>
                <th>زیرمجموعه‌ی</th>
                <th>تصویر</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->parent?->title ?? '-' }}</td>
                    <td>
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" style="width: 25px">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}">ویرایش</a> |
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('حذف دسته؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
