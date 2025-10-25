@extends('layouts.customer')

@section('title', 'ویرایش پروفایل')

@section('content')
    <h2 class="text-xl font-bold mb-4">ویرایش پروفایل</h2>

    @if ($profile->avatar)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $profile->avatar) }}"
                 alt="Avatar">
            <form method="POST" action="{{ route('dashboard.profile.avatar.destroy') }}">
                @csrf
                @method('DELETE')
                <button type="submit">
                    حذف آواتار
                </button>
            </form>
        </div>
    @endif

    <form method="POST"
          action="{{ route('dashboard.profile.update') }}"
          enctype="multipart/form-data">
        @csrf

        <label class="block">
            <span>آواتار</span>
            <input type="file" name="avatar">
        </label>

        <label class="block">
            <span>نام</span>
            <input type="text"
                   name="first_name"
                   value="{{ old('first_name', $profile->first_name) }}"
                   placeholder="نام">
        </label>

        {{-- نام خانوادگی --}}
        <label class="block">
            <span>نام خانوادگی</span>
            <input type="text"
                   name="last_name"
                   value="{{ old('last_name', $profile->last_name) }}"
                   placeholder="نام خانوادگی">
        </label>

        {{-- سن --}}
        <label class="block">
            <span >سن</span>
            <input type="number"
                   name="age"
                   value="{{ old('age', $profile->age) }}"
                   placeholder="سن">
        </label>

        {{-- جنسیت --}}
        <label class="block">
            <span>جنسیت</span>
            <select name="gender">
                <option value="">انتخاب جنسیت</option>
                <option value="male" {{ old('gender', $profile->gender) == 'male' ? 'selected' : '' }}>مرد</option>
                <option value="female" {{ old('gender', $profile->gender) == 'female' ? 'selected' : '' }}>زن</option>
                <option value="other" {{ old('gender', $profile->gender) == 'other' ? 'selected' : '' }}>دیگر</option>
            </select>
        </label>

        <label class="block">
            <span class="text-sm font-semibold">ایمیل</span>
            <input type="email"
                   name="email"
                   value="{{ old('email', $profile->email) }}"
                   placeholder="ایمیل">
        </label>

        <label >
            <span >درباره من</span>
            <textarea name="bio"
                      placeholder="کمی درباره خودتان بنویسید...">{{ old('bio', $profile->bio) }}</textarea>
        </label>

        {{-- دکمه ذخیره --}}
        <button type="submit">
            ذخیره تغییرات
        </button>
    </form>
@endsection
