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
            <a href="{{ route('dashboard.profile.create') }}">ایجاد پروفایل</a>
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

    @if (!$addresses)
        <div>
            <p class="mb-2">هنوز هیچ آدرسی ثبت نکرده‌اید.</p>
            <a href="{{ route('dashboard.addresses.create') }}">
                ایجاد آدرس جدید
            </a>
        </div>
    @else
        <div>
            <h3>آدرس‌های شما</h3>
            <a href="{{ route('dashboard.addresses.create') }}">
                افزودن آدرس جدید
            </a>
        </div>

        @foreach ($addresses as $address)
            <div>
                <p><strong>استان:</strong> {{ $address->province }}</p>
                <p><strong>شهر:</strong> {{ $address->city }}</p>
                <p><strong>کد پستی:</strong> {{ $address->postal_code ?? '---' }}</p>
                <p><strong>آدرس:</strong> {{ $address->address }}</p>
                <div>
                    <a href="{{ route('dashboard.addresses.edit', $address) }}">ویرایش</a>
                    <form method="POST" action="{{ route('dashboard.addresses.destroy', $address) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('آیا از حذف این آدرس مطمئن هستید؟')">
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
@endsection
