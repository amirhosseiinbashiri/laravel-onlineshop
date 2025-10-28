@extends('layouts.master')

@section('title', 'ورود با نام کاربری')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-50 px-4">

    <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md border border-gray-100">

        {{-- عنوان --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">ورود به حساب کاربری</h2>
            <p class="text-gray-500 text-sm">با نام کاربری خود وارد شوید</p>
        </div>

        {{-- فرم ورود --}}
        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-gray-700 mb-1" for="username">نام کاربری</label>
                <input type="text" id="username" name="username"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="نام کاربری خود را وارد کنید" required>
            </div>

            <div>
                <label class="block text-gray-700 mb-1" for="password">رمز عبور</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="رمز عبور" required>
            </div>

            {{-- دکمه ورود --}}
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition-all">
                ورود
            </button>
        </form>

        {{-- جداکننده --}}
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="mx-3 text-gray-400 text-sm">یا</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        {{-- ورود با شماره تماس --}}
        <div class="text-center">
            <a href="{{ route('login.otp') }}"
                class="inline-block text-blue-600 hover:text-blue-800 font-medium transition">
                ورود با شماره تماس و کد تایید
            </a>
        </div>

        {{-- ثبت‌نام --}}
        <div class="text-center mt-6 text-sm text-gray-600">
            حساب ندارید؟
            <a href="{{ route('register.form') }}" class="text-blue-600 hover:text-blue-800 font-semibold">ثبت‌نام کنید</a>
        </div>
    </div>
</div>
@endsection

