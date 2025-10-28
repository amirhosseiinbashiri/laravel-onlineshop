@extends('layouts.master')

@section('title', 'تأیید کد ارسال شده')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-50 px-4">

    <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md border border-gray-100">

        {{-- عنوان --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">تأیید شماره تماس</h2>
            <p class="text-gray-500 text-sm">کد ارسال‌شده به شماره شما را وارد کنید</p>
        </div>

        {{-- فرم تأیید --}}
        <form method="POST" action="{{ route('verify.submit') }}" class="space-y-5">
            @csrf
            <div>
                <label for="otp_code" class="block text-gray-700 mb-1">کد تأیید</label>
                <input type="text" name="otp_code" id="otp_code" maxlength="6"
                    class="w-full px-4 py-2 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 tracking-widest text-lg font-semibold"
                    placeholder="مثلاً 123456" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition-all">
                تأیید و ادامه
            </button>
        </form>

        {{-- تایمر و ارسال مجدد --}}
        <div class="text-center mt-6">
            <p id="timerText" class="text-gray-500 text-sm">
                می‌توانید تا <span id="timer" class="font-semibold text-blue-600">03:00</span> دیگر کد جدید دریافت کنید
            </p>

            <button id="resendBtn"
                class="hidden mt-3 w-full border border-blue-600 text-blue-600 hover:bg-blue-50 py-2 rounded-lg transition">
                ارسال مجدد کد
            </button>
        </div>

        {{-- لینک بازگشت --}}
        <div class="text-center mt-8 text-sm text-gray-600">
            <a href="{{ route('register.form') }}" class="text-blue-600 hover:text-blue-800 font-semibold">بازگشت به ثبت‌نام</a>
        </div>
    </div>
</div>

{{-- اسکریپت تایمر --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const timerElement = document.getElementById("timer");
        const timerText = document.getElementById("timerText");
        const resendBtn = document.getElementById("resendBtn");

        let timeLeft = 180; // 3 دقیقه = 180 ثانیه

        const countdown = setInterval(() => {
            const minutes = String(Math.floor(timeLeft / 60)).padStart(2, "0");
            const seconds = String(timeLeft % 60).padStart(2, "0");
            timerElement.textContent = `${minutes}:${seconds}`;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerText.classList.add("hidden");
                resendBtn.classList.remove("hidden");
            }
            timeLeft--;
        }, 1000);

        resendBtn.addEventListener("click", () => {
            resendBtn.textContent = "در حال ارسال...";
            resendBtn.disabled = true;

            // ارسال درخواست مجدد به سرور (در صورت نیاز Ajax)
            setTimeout(() => {
                resendBtn.textContent = "ارسال مجدد انجام شد ✅";
                resendBtn.classList.add("bg-green-50", "text-green-700", "border-green-500");
            }, 2000);
        });
    });
</script>
@endsection
