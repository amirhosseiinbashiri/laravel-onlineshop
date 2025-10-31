<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function create()
    {
        return view('dashboard.pages.profile.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->profile) {
            return redirect()->route('profile.edit')
                ->with('error', 'شما از قبل پروفایل دارید!');
        }
        $data = $request->validate([
            'avatar' => 'nullable|image|max:2048',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|in:male,female,other',
            'email' => 'nullable|email',
            'bio' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $data['user_id'] = auth()->id();

        Profile::create($data);

        return redirect()->route('dashboard')->with('success', 'پروفایل با موفقیت ایجاد شد!');
    }

    public function edit()
    {
        $profile = auth()->user()->profile;
        if (!$profile) {
            return redirect()->route('profile.create')->with('error', 'ابتدا پروفایل خود را ایجاد کنید.');
        }

        return view('dashboard.pages.profile.edit', compact('profile'));
    }


    public function update(Request $request)
    {
        $profile = auth()->user()->profile;

        $data = $request->validate([
            'avatar' => 'nullable|image|max:2048',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|in:male,female,other',
            'email' => 'nullable|email',
            'bio' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->update($data);

        return redirect()->route('dashboard')->with('success', 'پروفایل با موفقیت ویرایش شد!');
    }

    public function destroyAvatar()
    {
        $profile = auth()->user()->profile;

        if (!$profile || !$profile->avatar) {
            return back()->withErrors('شما آواتاری برای حذف ندارید.');
        }

        Storage::disk('public')->delete($profile->avatar);

        $profile->update(['avatar' => null]);

        return back()->with('success', 'آواتار با موفقیت حذف شد.');
    }

    public function show()
    {
        $profile = auth()->user()->profile;

        if (!$profile) {
            return redirect()->route('profile.create')
                ->with('status', 'ابتدا پروفایل خود را ایجاد کنید.');
        }

        return view('dashboard.pages.profile.show', compact('profile'));
    }

    public function destroyAccount(Request $request)
    {
        $user = auth()->user();

        if ($user->profile && $user->profile->avatar) {
            Storage::disk('public')->delete($user->profile->avatar);
        }

        $user->profile()->delete();

        $user->delete();

        auth()->logout();

        return redirect('/')
            ->with('status', 'حساب کاربری شما با موفقیت حذف شد.');
    }
}
