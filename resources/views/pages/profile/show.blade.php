@extends('layouts.customer')

@section('title', 'پروفایل من')

@section('content')
    <h2 class="text-xl font-bold mb-4">پروفایل من</h2>

    <div class="bg-white shadow rounded p-4">
        @if ($profile->avatar)
            <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full mb-4">
        @endif

        <p><strong>نام:</strong> {{ $profile->first_name ?? '---' }}</p>
        <p><strong>نام خانوادگی:</strong> {{ $profile->last_name ?? '---' }}</p>
        <p><strong>سن:</strong> {{ $profile->age ?? '---' }}</p>
        <p><strong>جنسیت:</strong>
            @if ($profile->gender === 'male')
                مرد
            @elseif ($profile->gender === 'female')
                زن
            @else
                دیگر
            @endif
        </p>
        <p><strong>ایمیل:</strong> {{ $profile->email ?? '---' }}</p>
        <p><strong>درباره من:</strong> {{ $profile->bio ?? '---' }}</p>

        <div class="mt-4 flex gap-2">
            <a href="{{ route('dashboard.profile.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                ویرایش پروفایل
            </a>

            <form action="{{ route('dashboard.profile.delete') }}" method="POST"
                onsubmit="return confirm('آیا از حذف حساب خود مطمئن هستید؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">
                    حذف حساب کاربری
                </button>
            </form>
        </div>
    </div>
@endsection
