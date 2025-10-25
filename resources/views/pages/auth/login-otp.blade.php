@extends('layouts.master')

@section('title', ' ورود با شماره تماس ')

@section('content')
    <h2>ورود با شماره تماس</h2>

    <form method="POST" action="{{ route('login.otp.submit') }}">
        @csrf
        <input type="text" name="phone" placeholder="شماره موبایل" required>

        <input type="text" name="otp_code" placeholder="کد تایید (اختیاری در مرحله اول)">

        <button type="submit">
            ارسال / ورود
        </button>
    </form>

    <div class="mt-4">
        <a href="{{ route('login') }}">ورود با رمز عبور</a>
    </div>
@endsection
