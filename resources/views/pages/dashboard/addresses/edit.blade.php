@extends('layouts.customer')

@section('title', 'ویرایش آدرس')

@section('content')
    <h2>ویرایش آدرس</h2>

    <form method="POST" action="{{ route('dashboard.addresses.update', $address) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="province">استان</label>
            <select name="province" id="province">
                <option value="">انتخاب استان</option>
              @foreach($provinces as $province)
                    <option value="{{ $province['name'] }}" {{ $address->province == $province['name'] ? 'selected' : '' }}>
                        {{ $province['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="city">شهر</label>
            <select name="city" id="city">
                <option value="{{ $address->city }}">{{ $address->city }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="postal_code">کد پستی</label>
            <input type="text" name="postal_code" id="postal_code"
                   value="{{ old('postal_code', $address->postal_code) }}"
                   >
        </div>

        <div class="mb-3">
            <label for="address">آدرس کامل</label>
            <textarea name="address" id="address" rows="3">{{ old('address', $address->address) }}</textarea>
        </div>

        <div class="flex gap-2">
            <button type="submit">ذخیره تغییرات</button>
            <a href="{{ route('dashboard.addresses.index') }}">بازگشت</a>
        </div>
    </form>
    @endsection

    @section('script')
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
