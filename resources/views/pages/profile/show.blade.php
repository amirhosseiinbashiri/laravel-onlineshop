@extends('layouts.customer')

@section('title', 'پروفایل من')

@section('content')
    <h2>پروفایل من</h2>
    <div>
        @if ($profile->avatar)
            <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar">
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

        <div >
            <a href="{{ route('dashboard.profile.edit') }}">
                ویرایش پروفایل
            </a>

            <form action="{{ route('dashboard.profile.delete') }}" method="POST"
                onsubmit="return confirm('آیا از حذف حساب خود مطمئن هستید؟');">
                @csrf
                @method('DELETE')
                <button type="submit">
                    حذف حساب کاربری
                </button>
            </form>
        </div>
    </div>
@endsection
