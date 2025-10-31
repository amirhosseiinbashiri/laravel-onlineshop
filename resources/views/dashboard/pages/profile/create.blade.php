@extends('dashboard.layouts.master')

@section('title', 'ایجاد پروفایل')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-100 px-4 py-8">

        <div class="bg-white/80 backdrop-blur-md border border-gray-100 shadow-xl rounded-2xl p-8 w-full max-w-2xl">

            {{-- عنوان --}}
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">ایجاد پروفایل کاربری</h2>
                <p class="text-gray-500 text-sm">اطلاعات خود را وارد کنید تا پروفایل شما تکمیل شود</p>
            </div>

            {{-- فرم --}}
            <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                {{-- تصویر آواتار --}}
                <div>
                    <label for="avatar" class="block text-gray-700 font-medium mb-1">تصویر پروفایل</label>
                    <input type="file" id="avatar" name="avatar"
                        class="block w-full py-3 pl-4 text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                {{-- نام و نام خانوادگی --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-gray-700 font-medium mb-1">نام</label>
                        <input type="text" id="first_name" name="first_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="مثلاً علی">
                    </div>
                    <div>
                        <label for="last_name" class="block text-gray-700 font-medium mb-1">نام خانوادگی</label>
                        <input type="text" id="last_name" name="last_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="مثلاً رضایی">
                    </div>
                </div>

                {{-- سن و جنسیت --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="age" class="block text-gray-700 font-medium mb-1">سن</label>
                        <input type="number" id="age" name="age"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="مثلاً ۲۵">
                    </div>
                    <div>
                        <label for="gender" class="block text-gray-700 font-medium mb-1">جنسیت</label>
                        <select id="gender" name="gender"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white">
                            <option value="">انتخاب کنید</option>
                            <option value="male">مرد</option>
                            <option value="female">زن</option>
                            <option value="other">دیگر</option>
                        </select>
                    </div>
                </div>

                {{-- ایمیل --}}
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-1">ایمیل</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="example@gmail.com">
                </div>

                {{-- درباره من --}}
                <div>
                    <label for="bio" class="block text-gray-700 font-medium mb-1">درباره من</label>
                    <textarea id="bio" name="bio" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none"
                        placeholder="چند خط درباره خودتان بنویسید..."></textarea>
                </div>

                {{-- دکمه ثبت --}}
                <div class="text-center">
                    <button type="submit"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-2.5 rounded-lg shadow-md transition-all">
                        ذخیره پروفایل
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
