@extends('pannel.layouts.master')

@section('title', 'مدیریت دسته‌بندی‌های وبلاگ')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow">

    <div class="flex flex-row-reverse justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">دسته‌بندی‌ها</h1>
        <a href="{{ route('archives.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + افزودن دسته جدید
        </a>
    </div>

    @if($archives->count())
        <table class="w-full text-right border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border-b">#</th>
                    <th class="p-3 border-b">عنوان</th>
                    <th class="p-3 border-b">تاریخ ایجاد</th>
                    <th class="p-3 border-b">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($archives as $archive)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border-b">{{ $loop->iteration }}</td>
                        <td class="p-3 border-b font-semibold text-gray-700">{{ $archive->title }}</td>
                        <td class="p-3 border-b text-gray-500">{{ jdate($archive->created_at)->format('Y/m/d') }}</td>
                        <td class="p-3 border-b flex gap-2 justify-end">
                            <a href="{{ route('archives.edit', $archive) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">ویرایش</a>

                            <form action="{{ route('archives.destroy', $archive) }}" method="POST"
                                  onsubmit="return confirm('آیا از حذف این دسته مطمئن هستید؟')">
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

        <div class="mt-4">{{ $archives->links() }}</div>
    @else
        <p class="text-center text-gray-500 mt-10">هیچ دسته‌بندی‌ای وجود ندارد.</p>
    @endif

</div>
@endsection
