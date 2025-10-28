@extends('layouts.master')

@section('title', 'ثبت‌نام')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-50 px-4">

    <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md border border-gray-100">

        {{-- عنوان --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">ایجاد حساب کاربری</h2>
            <p class="text-gray-500 text-sm">لطفاً اطلاعات خود را وارد کنید</p>
        </div>

        {{-- فرم ثبت‌نام --}}
        <form method="POST" action="{{ route('register.submit') }}" class="space-y-5">
            @csrf

            {{-- نام کاربری --}}
            <div>
                <label for="username" class="block text-gray-700 mb-1">نام کاربری</label>
                <input type="text" name="username" id="username"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="نام کاربری دلخواه" required>
            </div>

            {{-- شماره تماس --}}
            <div>
                <label for="phone" class="block text-gray-700 mb-1">شماره تماس</label>
                <input type="text" name="phone" id="phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="مثلاً 09123456789" required>
            </div>

            {{-- رمز عبور --}}
            <div>
                <label for="password" class="block text-gray-700 mb-1">رمز عبور</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="حداقل 8 کاراکتر" required>
            </div>

            {{-- تکرار رمز عبور --}}
            <div>
                <label for="password_confirmation" class="block text-gray-700 mb-1">تکرار رمز عبور</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="رمز عبور را دوباره وارد کنید" required>
            </div>

            {{-- دکمه ثبت‌نام --}}
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition-all">
                ایجاد حساب کاربری
            </button>
        </form>

        {{-- جداکننده --}}
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="mx-3 text-gray-400 text-sm">یا</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        {{-- ورود --}}
        <div class="text-center text-sm text-gray-600">
            قبلاً حساب دارید؟
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">وارد شوید</a>
        </div>
    </div>
</div>
@endsection
