@extends('dashboard.layouts.master')

@section('title', 'داشبورد')

@section('content')

    <section class="flex-1 p-6">
        <div class="bg-white rounded-xl shadow p-6">
            @if (!auth()->user()->phone_verify)
                <h2
                    class="text-right text-md font-bold mb-4 text-gray-500 flex flex-row-reverse justify-between items-center">
                    <p>برای فعال شدن امکانات پنل کاربری، نیاز هست ابتدا شماره تماس خود را تایید کنید</p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            class="text-blue-600">تایید شماره تماس</button>
                    </form>
                </h2>
            @else

                @if (!auth()->user()->profile)
                    <h2
                    class="text-right text-md font-bold mb-4 text-gray-500 flex flex-row-reverse justify-between items-center">
                    <p>شما هنوز پروفایل خودتون رو ایجاد نکردید</p>
                    <p class="text-blue-500 cursor-pointer hover:text-blue-700 transition-colors duration-300"><a
                            href="{{ route('profile.create') }}">ایجاد پروفایل</a></p>
                </h2>
                @else
                    {{-- اگر پروفایل موجود است --}}
                    @php
                        $profile = auth()->user()->profile;
                    @endphp

                    <div
                        class="flex flex-row-reverse items-center gap-4 p-4 bg-gray-50 border border-gray-200 rounded-lg hover:shadow-md transition-all duration-300">
                        {{-- آواتار --}}
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-blue-200 shadow-sm">
                            @if ($profile->avatar)
                                <img src="{{ asset('storage/' . $profile->avatar) }}" alt="avatar"
                                    class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $profile->first_name }}+{{ $profile->last_name }}&background=0D8ABC&color=fff"
                                    alt="avatar" class="w-full h-full object-cover">
                            @endif
                        </div>

                        {{-- اطلاعات پروفایل --}}
                        <div class="flex-1 text-right">
                            <h3 class="text-lg font-bold text-gray-800">
                                {{ $profile->first_name }} {{ $profile->last_name }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $profile->email ?? 'ایمیل ثبت نشده' }}
                            </p>

                            <div class="flex flex-row-reverse items-center justify-between mt-2 text-sm text-gray-600">
                                <span>👤
                                    {{ $profile->gender === 'male' ? 'مرد' : ($profile->gender === 'female' ? 'زن' : 'دیگر') }}</span>
                                <span>🎂 {{ $profile->age ? $profile->age . ' ساله' : 'سن نامشخص' }}</span>
                            </div>
                        </div>

                        {{-- دکمه ویرایش --}}
                        {{-- <div class="text-left">
                        <a href="{{ route('dashboard.profile.edit') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-semibold transition border-2 border-blue-600 rounded-md py-2 px-4">
                            ویرایش
                        </a>
                    </div> --}}
                    </div>


                @endif
            @endif

        </div>
    </section>

@endsection
