@extends('pannel.layouts.master')

@section('title', 'مدیریت تگ ها')

@section('content')
<div class="flex flex-col lg:flex-row gap-8 bg-gray-50 p-6 min-h-screen">

    {{-- 📋 لیست دسته‌ها --}}
    <div class="flex-1 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">تگ ها</h2>
        </div>

        @if ($tags->isEmpty())
            <p class="text-gray-500 text-center py-10">هیچ تگی وجود ندارد.</p>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-right">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-3">تگ</th>
                            <th class="px-4 py-3 text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($tags as $tag)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $tag->title }}</td>
                                <td class="px-4 py-3 text-center flex justify-center gap-3">
                                    <a href="{{ route('tags.edit', $tag) }}"
                                       class="text-blue-600 hover:text-blue-800 font-semibold transition">ویرایش</a>
                                    <form action="{{ route('tags.destroy', $tag) }}" method="POST"
                                          onsubmit="return confirm('آیا از حذف این تگ مطمئن هستید؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-semibold transition">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ➕ فرم ایجاد دسته جدید --}}
    <div class="w-full lg:w-1/3 bg-white rounded-2xl shadow-lg p-6 border border-gray-100 sticky top-6 h-fit">
        <h2 class="text-xl font-bold text-gray-800 mb-6">ایجاد تگ جدید</h2>

        <form method="POST" action="{{ route('tags.store') }}" class="space-y-4">
            @csrf

            {{-- عنوان --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">عنوان تگ</label>
                <input type="text" name="title" placeholder="مثلاً:  پوشاک"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('title') }}">
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- دکمه --}}
            <div class="pt-2">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition">
                    ذخیره تگ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
