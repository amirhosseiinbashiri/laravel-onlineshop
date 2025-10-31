@extends('dashboard.layouts.master')

@section('title', 'پروفایل من')

@section('content')
    <div class="flex justify-center items-center min-h-screen bg-gray-50">
        <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md border border-gray-100">

            {{-- عنوان صفحه --}}
            <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">پروفایل من</h2>

            {{-- آواتار کاربر --}}
            <div class="flex flex-col items-center mb-6">
                @if ($profile->avatar)
                    <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-blue-100 shadow-md">
                        <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar"
                            class="w-full h-full object-cover">
                    </div>
                @else
                    <div
                        class="w-28 h-28 flex items-center justify-center bg-gray-200 rounded-full text-gray-500 text-4xl shadow-inner">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            </div>

            {{-- اطلاعات پروفایل --}}
            <div class="space-y-3 text-gray-700 text-right">
                <p><span class="font-semibold text-gray-800">نام:</span> {{ $profile->first_name ?? '---' }}</p>
                <p><span class="font-semibold text-gray-800">نام خانوادگی:</span> {{ $profile->last_name ?? '---' }}</p>
                <p><span class="font-semibold text-gray-800">سن:</span> {{ $profile->age ?? '---' }}</p>
                <p><span class="font-semibold text-gray-800">جنسیت:</span>
                    @if ($profile->gender === 'male')
                        مرد
                    @elseif ($profile->gender === 'female')
                        زن
                    @else
                        دیگر
                    @endif
                </p>
                <p><span class="flex flex-row-reverse w-full font-semibold text-gray-800">:ایمیل</span> {{ $profile->email ?? '---' }}</p>
                <p>
                    <span class="font-semibold text-gray-800">درباره من:</span><br>
                    <span
                        class="block bg-gray-50 border border-gray-200 rounded-lg p-3 mt-1 text-gray-600 text-sm leading-relaxed">
                        {{ $profile->bio ?? '---' }}
                    </span>
                </p>
            </div>

            {{-- دکمه‌های عملیات --}}
            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-200">
                <a href="{{ route('profile.edit') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium shadow-md transition">
                    ویرایش پروفایل
                </a>

                <form action="{{ route('profile.delete') }}" method="POST"
                    onsubmit="return confirm('آیا از حذف حساب خود مطمئن هستید؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg font-medium shadow-md transition">
                        حذف حساب
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
