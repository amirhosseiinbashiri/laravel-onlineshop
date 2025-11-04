@extends('pannel.layouts.master')

@section('title', 'مدیریت مقالات')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">لیست مقالات</h1>
        <a href="{{ route('blogs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + افزودن مقاله جدید
        </a>
    </div>

    @if ($blogs->count())
        <table class="w-full text-right border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border-b">#</th>
                    <th class="p-3 border-b">عنوان</th>
                    <th class="p-3 border-b">دسته‌بندی</th>
                    <th class="p-3 border-b">نویسنده</th>
                    <th class="p-3 border-b">وضعیت</th>
                    <th class="p-3 border-b">تاریخ ایجاد</th>
                    <th class="p-3 border-b">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border-b">{{ $loop->iteration }}</td>
                        <td class="p-3 border-b font-semibold text-gray-700"><a href="{{ route('blogs.show', $blog) }}">{{ $blog->title }}</a></td>
                        <td class="p-3 border-b">{{ $blog->archive->title ?? '-' }}</td>
                        <td class="p-3 border-b">{{ $blog->author->name ?? '-' }}</td>
                        <td class="p-3 border-b">
                            @if($blog->is_published)
                                <span class="text-green-600 font-semibold">منتشر شده</span>
                            @else
                                <span class="text-gray-500">پیش‌نویس</span>
                            @endif
                        </td>
                        <td class="p-3 border-b text-gray-500">{{ jdate($blog->created_at)->format('Y/m/d') }}</td>
                        <td class="p-3 border-b flex gap-2 justify-end">
                            <a href="{{ route('blogs.edit', $blog) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">ویرایش</a>

                            <form action="{{ route('blogs.destroy', $blog) }}" method="POST"
                                  onsubmit="return confirm('آیا از حذف این مقاله مطمئن هستید؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $blogs->links() }}</div>
    @else
        <p class="text-center text-gray-500 mt-10">هیچ مقاله‌ای ثبت نشده است.</p>
    @endif
</div>
@endsection
