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

    <div>

        @if(!auth()->user()->profile)
            <p>شما هنوز پروفایل خود را ایجاد نکرده‌اید.</p>
            <a href="{{ route('dashboard.profile.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">ایجاد پروفایل</a>
        @else
            @php $p = auth()->user()->profile; @endphp
            <div>
                @if($p->avatar)
                    <img src="{{ asset('storage/'.$p->avatar) }}">
                @else
                    <div>
                        {{ mb_substr($p->first_name ?? '؟', 0, 1) }}
                    </div>
                @endif
                <div>
                    <h2>{{ $p->first_name }} {{ $p->last_name }}</h2>
                    <p>{{ $p->email }}</p>
                    <p>{{ $p->bio }}</p>
                </div>
            </div>
            <div>
                <a href="{{ route('dashboard.profile.edit') }}">ویرایش پروفایل</a><span> --|-- </span>
                <a href="{{ route('dashboard.profile.show') }}">نمایش پروفایل</a>
            </div>
        @endif
    </div>
@endsection
