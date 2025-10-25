@extends('layouts.customer')

@section('title', 'ایجاد پروفایل')

@section('content')
    <h2>ایجاد پروفایل</h2>
    <form method="POST" action="{{ route('dashboard.profile.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="avatar">
        <input type="text" name="first_name" placeholder="نام">
        <input type="text" name="last_name" placeholder="نام خانوادگی">
        <input type="number" name="age" placeholder="سن">
        <select name="gender">
            <option value="">انتخاب جنسیت</option>
            <option value="male">مرد</option>
            <option value="female">زن</option>
            <option value="other">دیگر</option>
        </select>
        <input type="email" name="email" placeholder="ایمیل">
        <textarea name="bio" placeholder="درباره من..."></textarea>
        <button type="submit" >ذخیره</button>
    </form>
@endsection
