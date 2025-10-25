@extends('layouts.customer')

@section('title', 'داشبورد')

@section('content')
    <div class="">
        <h1 class="">👋 خوش آمدی {{ $user->username }}</h1>
        <p class="">شما وارد حساب کاربری خود شده‌اید.</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                خروج از حساب
            </button>
        </form>
    </div>
@endsection
