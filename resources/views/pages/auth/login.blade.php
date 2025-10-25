@extends('layouts.master')

@section('title', ' ورود با نام کاربری')

@section('content')
    <h2>ورود با نام کاربری</h2>
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <input type="text" name="username" placeholder="نام کاربری">
        <input type="password" name="password" placeholder="رمز عبور">
        <button type="submit">ورود</button>
    </form>
    <div>
        <a href="{{ route('login.otp') }}">ورود با شماره تماس و کد تایید</a>
    </div>
@endsection
