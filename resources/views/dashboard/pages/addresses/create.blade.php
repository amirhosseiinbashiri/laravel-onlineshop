@extends('dashboard.layouts.master')

@section('title', 'ایجاد آدرس جدید')

@section('content')
    <div class="flex justify-center items-start min-h-screen bg-gray-50 py-10 px-4">
        <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-2xl border border-gray-100">

            {{-- عنوان --}}
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">ایجاد آدرس جدید</h2>

            {{-- فرم --}}
            <form method="POST" action="{{ route('addresses.store') }}" class="space-y-6">
                @csrf

                {{-- نام --}}
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-1">نام </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="مثلاً خانه">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- استان --}}
                <div>
                    <label for="province" class="block text-gray-700 font-semibold mb-1">استان</label>
                    <select name="province" id="province"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">انتخاب استان</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province['name'] }}"
                                {{ old('province') == $province['name'] ? 'selected' : '' }}>
                                {{ $province['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('province')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- شهر --}}
                <div>
                    <label for="city" class="block text-gray-700 font-semibold mb-1">شهر</label>
                    <select name="city" id="city"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">ابتدا استان را انتخاب کنید</option>
                    </select>
                    @error('city')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- کد پستی --}}
                <div>
                    <label for="postal_code" class="block text-gray-700 font-semibold mb-1">کد پستی</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="مثلاً 1234567890">
                    @error('postal_code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- آدرس کامل --}}
                <div>
                    <label for="address" class="block text-gray-700 font-semibold mb-1">آدرس کامل</label>
                    <textarea name="address" id="address" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="آدرس دقیق خود را وارد کنید...">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- دکمه‌ها --}}
                <div class="flex flex-row-reverse justify-between items-center mt-6 pt-4 border-t border-gray-200">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md font-semibold transition">
                        ثبت آدرس
                    </button>
                    <a href="{{ route('addresses.index') }}"
                        class="text-gray-600 hover:text-gray-800 font-medium transition">
                        بازگشت
                    </a>
                </div>
            </form>
        </div>
    </div>
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
