@extends('layouts.master')

@section('title', 'ثبت نام')

@section('content')
    <h2>ثبت نام</h2>
    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div class="">
            <label for="username">نام کاربری</label>
            <input type="text" name="username" required>
        </div>
        <div class="">
            <label for="phone">شماره تماس</label>
            <input type="text" name="phone" required>
        </div>
        <div class="">
            <label for="password">رمز عبور</label>
            <input type="password" name="password" required>
        </div>
        <div class="">
            <label for="password_confirmation">تکرار رمز عبور</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <input type="submit" value="ایجاد حساب کاربری">
    </form>
@endsection
