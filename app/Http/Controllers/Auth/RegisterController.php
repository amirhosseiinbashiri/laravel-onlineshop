<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /**
     * نمایش فرم ثبت‌نام
     */
    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }


    /**
     * مرحله اول ثبت‌نام کاربر (ارسال اطلاعات اولیه و تولید OTP)
     */
    public function register(Request $request)
    {
        // ✅ اعتبارسنجی فیلدها
        $data = $request->validate([
            'username' => 'required|string|unique:users,username',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|confirmed|min:6',
        ]);

        // ✅ نرمال‌سازی شماره تماس‌های ایرانی
        // این بخش برای یکسان‌سازی ورودی کاربرهاست (مثلاً 0912... یا +98912... یا 912...)
        $phone = $this->normalizeIranianPhone($request->phone);

        // ✅ تولید کد تأیید (OTP)
        $otp = rand(10000, 99999);

        // ✅ ساخت رکورد کاربر در دیتابیس
        $user = User::create([
            'username' => $data['username'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(3),
        ]);

        // ✅ ذخیره ID کاربر در session برای مرحله تأیید
        // (توجه: در کدت قبلی تایپوی "varify_user_id" داشتی، اصلاح شد به "verify_user_id")
        Session::put('verify_user_id', $user->id);

        // ✅ شبیه‌سازی ارسال پیامک OTP با Log (در محیط dev)
        // در آینده میشه این بخش رو به سامانه پیامکی متصل کرد.
        Log::info("OTP for {$user->phone} is: {$otp}");

        // ✅ هدایت کاربر به صفحه‌ی وارد کردن کد
        return redirect()
            ->route('verify.form')
            ->with('status', 'کد تأیید به شماره تماس شما ارسال شد (در لاگ نمایش داده شده)');
    }

    /**
     * نمایش فرم تأیید کد ارسال شده (OTP)
     */
    public function showVerifyForm()
    {
        return view('pages.auth.verify');
    }

    /**
     * مرحله دوم ثبت‌نام (بررسی صحت و انقضای کد OTP)
     */
    public function verify(Request $request)
    {
        // ✅ بررسی صحت ورودی
        $request->validate([
            'otp_code' => 'required|numeric'
        ]);

        // ✅ گرفتن کاربر از Session
        $userId = Session::get('verify_user_id');
        $user = User::find($userId);

        // ✅ اگر کاربر وجود نداشت (مثلاً از Session حذف شده یا رکوردش ناقص مونده)
        if (!$user) {
            // تلاش برای حذف رکورد ناقص در صورت وجود
            // چون ممکنه قبلاً حذف نشده باشه یا دیتابیس هنوز اون شماره رو نگه داشته باشه
            $userId = Session::get('verify_user_id');
            User::where('id', $userId)->delete();

            // حذف Session تا کاربر دوباره ثبت‌نام کنه بدون خطا
            Session::forget('verify_user_id');

            return redirect()
                ->route('register.form')
                ->withErrors('اطلاعات قبلی شما منقضی شده است، لطفاً دوباره ثبت‌نام کنید.');
        }

        // ✅ اگر کد منقضی شده بود
        if ($user->otp_expires_at < now()) {
            // اینجا می‌تونیم OTP جدیدی تولید کنیم و برای کاربر بفرستیم (در آینده)
            $newOtp = rand(10000, 99999);
            $user->update([
                'otp_code' => $newOtp,
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            Log::info("New OTP for {$user->phone} is: {$newOtp}");

            return redirect()
                ->route('verify.form')
                ->withErrors('کد منقضی شده است، کد جدید برای شما ارسال شد (در لاگ نمایش داده شده)');
        }

        // ✅ بررسی تطابق کد ارسالی با کد کاربر
        if ($user->otp_code != $request->otp_code) {
            return back()->withErrors('کد وارد شده صحیح نیست.');
        }

        // ✅ در صورت تأیید موفق:
        // پاک کردن مقادیر OTP از جدول (امنیت)
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        // ✅ ورود خودکار کاربر
        auth()->login($user);

        // ✅ حذف session مربوط به OTP
        Session::forget('verify_user_id');

        // ✅ انتقال به داشبورد مشتری
        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'ثبت‌نام شما با موفقیت انجام شد!');
    }

    /**
     * ارسال مجدد کد تأیید (Resend OTP)
     */
    public function resendOtp(Request $request)
    {
        $userId = Session::get('verify_user_id');
        $user = User::find($userId);

        // ✅ اگر کاربر وجود نداشت (مثلاً از Session حذف شده یا رکوردش ناقص مونده)
        if (!$user) {
            // تلاش برای حذف رکورد ناقص در صورت وجود
            // چون ممکنه قبلاً حذف نشده باشه یا دیتابیس هنوز اون شماره رو نگه داشته باشه
            $userId = Session::get('verify_user_id');
            User::where('id', $userId)->delete();

            // حذف Session تا کاربر دوباره ثبت‌نام کنه بدون خطا
            Session::forget('verify_user_id');

            return redirect()
                ->route('register.form')
                ->withErrors('اطلاعات قبلی شما منقضی شده است، لطفاً دوباره ثبت‌نام کنید.');
        }
        // بررسی اینکه آیا OTP قبلی هنوز منقضی نشده
        if ($user->otp_expires_at > now()) {
            $remaining = $user->otp_expires_at->diffInSeconds(now());
            return back()->withErrors("لطفاً {$remaining} ثانیه دیگر برای ارسال مجدد صبر کنید.");
        }

        // تولید OTP جدید
        $newOtp = rand(10000, 99999);

        $user->update([
            'otp_code' => $newOtp,
            'otp_expires_at' => now()->addMinutes(3),
        ]);

        // شبیه‌سازی ارسال (در لاگ)
        Log::info("New OTP for {$user->phone} is: {$newOtp}");

        return back()->with('status', 'کد تأیید جدید ارسال شد (در لاگ نمایش داده شده)');
    }

    /**
     * متد کمکی برای نرمال‌سازی شماره تماس ایرانی
     * (به عنوان مثال: 0912..., +98912..., 912... → 0912...)
     */
    private function normalizeIranianPhone(string $phone): string
    {
        // حذف فاصله‌ها و کاراکترهای اضافی
        $phone = preg_replace('/\s+/', '', $phone);

        // اگر با +98 شروع میشه → به 0 تغییر بده
        if (str_starts_with($phone, '+98')) {
            $phone = '0' . substr($phone, 3);
        }

        // اگر با 98 شروع میشه → به 0 تغییر بده
        if (str_starts_with($phone, '98')) {
            $phone = '0' . substr($phone, 2);
        }

        // اگر کاربر فقط 9 زده (مثل 9121234567) → 0 جلوش اضافه بشه
        if (str_starts_with($phone, '9')) {
            $phone = '0' . $phone;
        }

        return $phone;
    }
}
