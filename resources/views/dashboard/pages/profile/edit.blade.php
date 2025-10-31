@extends('dashboard.layouts.master')

@section('title', 'ویرایش پروفایل')

@section('content')
    <div class="flex justify-center items-center min-h-screen bg-gray-50">
        <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-lg border border-gray-100">

            {{-- عنوان صفحه --}}
            <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">ویرایش پروفایل</h2>

            {{-- آواتار فعلی و دکمه حذف --}}
            @if ($profile->avatar)
                <div class="flex flex-col items-center mb-6">
                    <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-blue-100 shadow-md">
                        <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar"
                            class="w-full h-full object-cover">
                    </div>
                    <form method="POST" action="{{ route('profile.avatar.destroy') }}" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-semibold transition">
                            حذف آواتار
                        </button>
                    </form>
                </div>
            @endif

            {{-- فرم ویرایش --}}
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                {{-- آواتار جدید --}}
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">آواتار جدید</label>
                    <input type="file" name="avatar"
                        class="py-2 pl-4 block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:ring-2 focus:ring-blue-400">
                </div>

                {{-- نام --}}
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">نام</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $profile->first_name) }}"
                        placeholder="نام"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                {{-- نام خانوادگی --}}
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">نام خانوادگی</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $profile->last_name) }}"
                        placeholder="نام خانوادگی"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                {{-- سن --}}
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">سن</label>
                    <input type="number" name="age" value="{{ old('age', $profile->age) }}" placeholder="سن"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                {{-- جنسیت --}}
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">جنسیت</label>
                    <select name="gender"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="">انتخاب جنسیت</option>
                        <option value="male" {{ old('gender', $profile->gender) == 'male' ? 'selected' : '' }}>مرد
                        </option>
                        <option value="female" {{ old('gender', $profile->gender) == 'female' ? 'selected' : '' }}>زن
                        </option>
                        <option value="other" {{ old('gender', $profile->gender) == 'other' ? 'selected' : '' }}>دیگر
                        </option>
                    </select>
                </div>

                {{-- ایمیل --}}
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">ایمیل</label>
                    <input type="email" name="email" value="{{ old('email', $profile->email) }}" placeholder="ایمیل"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                {{-- بیو --}}
                <div>
                    <label class="block text-gray-700 mb-1 font-medium">درباره من</label>
                    <textarea name="bio" placeholder="کمی درباره خودتان بنویسید..." rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                {{-- دکمه ذخیره --}}
                <div class="text-center pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition-all duration-300">
                        ذخیره تغییرات
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
