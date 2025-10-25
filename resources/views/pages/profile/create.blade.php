@extends('layouts.customer')

@section('title', 'ایجاد پروفایل')

@section('content')
    <h2 class="text-xl font-bold mb-4">ایجاد پروفایل</h2>
    <form method="POST" action="{{ route('dashboard.profile.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="avatar" class="w-full border rounded p-2 mb-3">
        <input type="text" name="first_name" placeholder="نام" class="w-full border rounded p-2 mb-3">
        <input type="text" name="last_name" placeholder="نام خانوادگی" class="w-full border rounded p-2 mb-3">
        <input type="number" name="age" placeholder="سن" class="w-full border rounded p-2 mb-3">
        <select name="gender" class="w-full border rounded p-2 mb-3">
            <option value="">انتخاب جنسیت</option>
            <option value="male">مرد</option>
            <option value="female">زن</option>
            <option value="other">دیگر</option>
        </select>
        <input type="email" name="email" placeholder="ایمیل" class="w-full border rounded p-2 mb-3">
        <textarea name="bio" placeholder="درباره من..." class="w-full border rounded p-2 mb-3"></textarea>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">ذخیره</button>
    </form>
@endsection
