@extends('layouts.master')

@section('title', 'ورود با شماره تماس')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-50 px-4">

    <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md border border-gray-100">

        {{-- عنوان --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">ورود با شماره تماس</h2>
            <p class="text-gray-500 text-sm">شماره موبایل خود را وارد کنید تا کد تایید برایتان ارسال شود</p>
        </div>

        {{-- فرم ورود با شماره --}}
        <form method="POST" action="{{ route('login.otp.submit') }}" class="space-y-5">
            @csrf

            {{-- شماره موبایل --}}
            <div>
                <label class="block text-gray-700 mb-1" for="phone">شماره موبایل</label>
                <input type="text" id="phone" name="phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="مثلاً 09123456789" required>
            </div>

            {{-- کد تایید (اختیاری در مرحله اول) --}}
            <div>
                <label class="block text-gray-700 mb-1" for="otp_code">کد تایید</label>
                <input type="text" id="otp_code" name="otp_code"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="در صورت دریافت کد، اینجا وارد کنید">
            </div>

            {{-- دکمه ارسال / ورود --}}
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition-all">
                ارسال / ورود
            </button>
        </form>

        {{-- جداکننده --}}
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="mx-3 text-gray-400 text-sm">یا</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        {{-- ورود با رمز عبور --}}
        <div class="text-center">
            <a href="{{ route('login') }}"
                class="inline-block text-blue-600 hover:text-blue-800 font-medium transition">
                ورود با نام کاربری و رمز عبور
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
