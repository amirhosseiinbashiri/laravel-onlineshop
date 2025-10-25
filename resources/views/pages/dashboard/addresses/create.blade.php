@extends('layouts.customer')

@section('title', 'ایجاد آدرس جدید')

@section('content')
    <h2>ایجاد آدرس جدید</h2>

    <form method="POST" action="{{ route('dashboard.addresses.store') }}">
        @csrf
        <div class="mb-3">
            <label for="province">استان</label>
            <select name="province" id="province">
                <option value="">انتخاب استان</option>
                @foreach($provinces as $province)
                    <option value="{{ $province['name'] }}" {{ old('province') == $province['name'] ? 'selected' : '' }}>
                        {{ $province['name'] }}
                    </option>
                @endforeach
            </select>
            @error('province')
                <p >{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="city">شهر</label>
            <select name="city" id="city">
                <option value="">ابتدا استان را انتخاب کنید</option>
            </select>
            @error('city')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="postal_code">کد پستی</label>
            <input type="text" name="postal_code" id="postal_code"
                   value="{{ old('postal_code') }}"
                  >
            @error('postal_code')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address">آدرس کامل</label>
            <textarea name="address" id="address" rows="3"
                      >{{ old('address') }}</textarea>
            @error('address')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit">ثبت آدرس</button>
            <a href="{{ route('dashboard.addresses.index') }}" >بازگشت</a>
        </div>
    </form>

    <script>
        document.getElementById('province').addEventListener('change', function() {
            let province = this.value;
            let citySelect = document.getElementById('city');
            citySelect.innerHTML = '<option>در حال بارگذاری...</option>';

            if (!province) {
                citySelect.innerHTML = '<option>ابتدا استان را انتخاب کنید</option>';
                return;
            }

            fetch(`/api/cities/${province}`)
                .then(res => res.json())
                .then(data => {

                    citySelect.innerHTML = '<option value="">انتخاب شهر</option>';
                    data[0].cities.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.name}">${city.name}</option>`;
                    });
                })
                .catch(() => {
                    citySelect.innerHTML = '<option>خطا در دریافت شهرها</option>';
                });
        });
    </script>
@endsection
