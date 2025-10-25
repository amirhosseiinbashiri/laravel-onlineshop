@extends('layouts.master')

@section('title', 'ثبت نام')

@section('content')

    @if (session('status'))
        <div class="">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="">{{ $errors->first() }}</div>
    @endif

    <hr>

    <h2 class="text-xl font-bold mb-4">تأیید کد ارسال شده</h2>

    <hr>

    <div class="">
        <form method="POST" action="{{ route('verify.submit') }}">
            @csrf
            <div class="">
                <label>کد تأیید</label>
                <input type="text" name="otp_code" class="" required>
            </div>
            <input type="submit" value="submit">
        </form>
    </div>
@endsection
