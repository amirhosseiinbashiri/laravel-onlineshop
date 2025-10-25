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

    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|unique:users,username',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|confirmed|min:6',
        ]);

        $phone = $this->normalizeIranianPhone($request->phone);

        $otp = rand(10000, 99999);

        $user = User::create([
            'username' => $data['username'],
            'phone' => $phone,
            'password' => $data['password'],
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(3),
        ]);

        Session::put('verify_user_id', $user->id);
        Log::info("OTP for {$user->phone} is: {$otp}");

        return redirect()
            ->route('verify.form')
            ->with('status', 'کد تأیید به شماره تماس شما ارسال شد (در لاگ نمایش داده شده)');
    }

    public function showVerifyForm()
    {
        return view('pages.auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|numeric'
        ]);

        $userId = Session::get('verify_user_id');
        $user = User::find($userId);

        if (!$user) {
            $userId = Session::get('verify_user_id');
            User::where('id', $userId)->delete();

            Session::forget('verify_user_id');

            return redirect()
                ->route('register.form')
                ->withErrors('اطلاعات قبلی شما منقضی شده است، لطفاً دوباره ثبت‌نام کنید.');
        }

        if ($user->otp_expires_at < now()) {
            $newOtp = rand(10000, 99999);
            $user->update([
                'otp_code' => $newOtp,
                'otp_expires_at' => now()->addMinutes(3),
            ]);

            Log::info("New OTP for {$user->phone} is: {$newOtp}");

            return redirect()
                ->route('verify.form')
                ->withErrors('کد منقضی شده است، کد جدید برای شما ارسال شد (در لاگ نمایش داده شده)');
        }

        if ($user->otp_code != $request->otp_code) {
            return back()->withErrors('کد وارد شده صحیح نیست.');
        }

        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        auth()->login($user);

        Session::forget('verify_user_id');

        return redirect()
            ->route('dashboard')
            ->with('success', 'ثبت‌نام شما با موفقیت انجام شد!');
    }


    public function resendOtp(Request $request)
    {
        $userId = Session::get('verify_user_id');
        $user = User::find($userId);

        if (!$user) {

            $userId = Session::get('verify_user_id');
            User::where('id', $userId)->delete();

            Session::forget('verify_user_id');

            return redirect()
                ->route('register.form')
                ->withErrors('اطلاعات قبلی شما منقضی شده است، لطفاً دوباره ثبت‌نام کنید.');
        }
        if ($user->otp_expires_at > now()) {
            $remaining = $user->otp_expires_at->diffInSeconds(now());
            return back()->withErrors("لطفاً {$remaining} ثانیه دیگر برای ارسال مجدد صبر کنید.");
        }

        $newOtp = rand(10000, 99999);

        $user->update([
            'otp_code' => $newOtp,
            'otp_expires_at' => now()->addMinutes(3),
        ]);

        Log::info("New OTP for {$user->phone} is: {$newOtp}");

        return back()->with('status', 'کد تأیید جدید ارسال شد (در لاگ نمایش داده شده)');
    }


    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (auth()->attempt($credentials, $request->boolean('remember'))) {
            $user = auth()->user();

            $user->touch();

            if ($user->is_admin) {
                return redirect()->route('pannel')->with('success', "مدیر گرامی {$user->username} خوش آمدید");
            }

            return redirect()->route('dashboard')->with('success', "خوش آمدی {$user->username}");
        }

        return back()->withErrors('نام کاربری یا رمز عبور اشتباه است.');
    }

    public function showLoginOtpForm()
    {
        return view('pages.auth.login-otp');
    }

    public function loginWithOtp(Request $request)
    {

        $data = $request->validate([
            'phone' => 'required|string',
            'otp_code' => 'nullable|numeric',
        ]);

        $phone = $this->normalizeIranianPhone($request->phone);
        $user = User::where('phone', $phone)->first();

        if (!isset($data['otp_code'])) {
            if (!$user) {
                return back()->withErrors('کاربری با این شماره یافت نشد.');
            }

            $otp = rand(10000, 99999);

            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(3),
            ]);

            Session::put('login_user_id', $user->id);
            Log::info("OTP for login {$user->phone} is: {$otp}");

            return redirect()
                ->route('login.otp')
                ->with('status', 'کد ورود برای شما ارسال شد (در لاگ نمایش داده شده)');
        }

        $userId = Session::get('login_user_id');
        $user = User::find($userId);

        if (!$user) {
            Session::forget('login_user_id');
            return redirect()->route('login.otp')->withErrors('کاربر یافت نشد. دوباره تلاش کنید.');
        }

        if ($user->otp_expires_at < now()) {
            $newOtp = rand(10000, 99999);
            $user->update([
                'otp_code' => $newOtp,
                'otp_expires_at' => now()->addMinutes(3),
            ]);
            Log::info("New OTP for login {$user->phone} is: {$newOtp}");
            return back()->withErrors('کد منقضی شده است، کد جدید ارسال شد.');
        }

        if ($user->otp_code != $request->otp_code) {
            return back()->withErrors('کد وارد شده اشتباه است.');
        }

        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        $user->touch();

        Session::forget('login_user_id');
        auth()->login($user);

        if ($user->is_admin) {
            return redirect()->route('pannel')->with('success', "مدیر گرامی {$user->username} خوش آمدید");
        }

        return redirect()->route('dashboard')->with('success', "خوش آمدی {$user->username}");
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'با موفقیت از حساب خود خارج شدید.');
    }


    // helpers
    private function normalizeIranianPhone(string $phone): string
    {
        $phone = preg_replace('/\s+/', '', $phone);

        if (str_starts_with($phone, '+98')) {
            $phone = '0' . substr($phone, 3);
        }

        if (str_starts_with($phone, '98')) {
            $phone = '0' . substr($phone, 2);
        }

        if (str_starts_with($phone, '9')) {
            $phone = '0' . $phone;
        }

        return $phone;
    }
}
