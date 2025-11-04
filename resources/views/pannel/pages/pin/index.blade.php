@extends('pannel.layouts.master')

@section('title', 'مدیریت پین‌ها')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow">

    <div class="flex flex-row-reverse justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">مدیریت پین‌ها (تگ‌ها)</h1>
        <a href="{{ route('pins.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            + افزودن پین جدید
        </a>
    </div>

    @if($pins->count())
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
                @foreach($pins as $pin)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border-b">{{ $loop->iteration }}</td>
                        <td class="p-3 border-b font-semibold text-gray-700">{{ $pin->name }}</td>
                        <td class="p-3 border-b text-gray-500">{{ jdate($pin->created_at)->format('Y/m/d') }}</td>
                        <td class="p-3 border-b flex gap-2 justify-end">
                            <a href="{{ route('pins.edit', $pin) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">ویرایش</a>

                            <form action="{{ route('pins.destroy', $pin) }}" method="POST"
                                  onsubmit="return confirm('آیا از حذف این پین مطمئن هستید؟')">
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

        <div class="mt-4">{{ $pins->links() }}</div>
    @else
        <p class="text-center text-gray-500 mt-10">هیچ پینی وجود ندارد.</p>
    @endif

</div>
@endsection
