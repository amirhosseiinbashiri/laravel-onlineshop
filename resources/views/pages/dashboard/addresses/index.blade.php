@extends('layouts.customer')

@section('title', 'آدرس‌ها')

@section('content')
    <h2>آدرس‌های من</h2>

    @if ($addresses->isEmpty())
        <p>هیچ آدرسی ثبت نشده.</p>
        <a href="{{ route('dashboard.addresses.create') }}">
            ایجاد آدرس جدید
        </a>
    @else
        <a href="{{ route('dashboard.addresses.create') }}">
            افزودن آدرس جدید
        </a>

        @foreach ($addresses as $address)
            <div class="border rounded p-3 mb-3">
                <p><strong>استان:</strong> {{ $address->province }}</p>
                <p><strong>شهر:</strong> {{ $address->city }}</p>
                <p><strong>کد پستی:</strong> {{ $address->postal_code ?? '---' }}</p>
                <p><strong>آدرس:</strong> {{ $address->address }}</p>

                <div class="mt-2 flex gap-2">
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
