@extends('layouts.customer')

@section('title', 'ویرایش پروفایل')

@section('content')
    <h2 class="text-xl font-bold mb-4">ویرایش پروفایل</h2>

    {{-- ✅ نمایش آواتار و امکان حذف آن --}}
    @if ($profile->avatar)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $profile->avatar) }}"
                 alt="Avatar"
                 class="w-24 h-24 rounded-full mb-2 border shadow">
            <form method="POST" action="{{ route('dashboard.profile.avatar.destroy') }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    حذف آواتار
                </button>
            </form>
        </div>
    @endif

    {{-- ✅ فرم ویرایش پروفایل --}}
    <form method="POST"
          action="{{ route('dashboard.profile.update') }}"
          enctype="multipart/form-data"
          class="max-w-md space-y-3">
        @csrf

        {{-- آواتار --}}
        <label class="block">
            <span class="text-sm font-semibold">آواتار</span>
            <input type="file" name="avatar" class="w-full border rounded p-2 mt-1">
        </label>

        {{-- نام --}}
        <label class="block">
            <span class="text-sm font-semibold">نام</span>
            <input type="text"
                   name="first_name"
                   value="{{ old('first_name', $profile->first_name) }}"
                   placeholder="نام"
                   class="w-full border rounded p-2 mt-1">
        </label>

        {{-- نام خانوادگی --}}
        <label class="block">
            <span class="text-sm font-semibold">نام خانوادگی</span>
            <input type="text"
                   name="last_name"
                   value="{{ old('last_name', $profile->last_name) }}"
                   placeholder="نام خانوادگی"
                   class="w-full border rounded p-2 mt-1">
        </label>

        {{-- سن --}}
        <label class="block">
            <span class="text-sm font-semibold">سن</span>
            <input type="number"
                   name="age"
                   value="{{ old('age', $profile->age) }}"
                   placeholder="سن"
                   class="w-full border rounded p-2 mt-1">
        </label>

        {{-- جنسیت --}}
        <label class="block">
            <span class="text-sm font-semibold">جنسیت</span>
            <select name="gender" class="w-full border rounded p-2 mt-1">
                <option value="">انتخاب جنسیت</option>
                <option value="male" {{ old('gender', $profile->gender) == 'male' ? 'selected' : '' }}>مرد</option>
                <option value="female" {{ old('gender', $profile->gender) == 'female' ? 'selected' : '' }}>زن</option>
                <option value="other" {{ old('gender', $profile->gender) == 'other' ? 'selected' : '' }}>دیگر</option>
            </select>
        </label>

        {{-- ایمیل --}}
        <label class="block">
            <span class="text-sm font-semibold">ایمیل</span>
            <input type="email"
                   name="email"
                   value="{{ old('email', $profile->email) }}"
                   placeholder="ایمیل"
                   class="w-full border rounded p-2 mt-1">
        </label>

        {{-- درباره من --}}
        <label class="block">
            <span class="text-sm font-semibold">درباره من</span>
            <textarea name="bio"
                      placeholder="کمی درباره خودتان بنویسید..."
                      class="w-full border rounded p-2 mt-1 h-24">{{ old('bio', $profile->bio) }}</textarea>
        </label>

        {{-- دکمه ذخیره --}}
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            ذخیره تغییرات
        </button>
    </form>
@endsection
