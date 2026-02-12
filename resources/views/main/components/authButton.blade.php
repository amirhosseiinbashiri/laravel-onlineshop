@auth
    <a class="py-2 px-4 rounded-md bg-sky-600 text-white font-bold hover:bg-sky-800 transition-colors duration-300" href="{{ route('dashboard') }}">پنل کاربری</a>
@else
    <a class="py-2 px-4 rounded-md bg-sky-600 text-white font-bold hover:bg-sky-800 transition-colors duration-300" href="{{ route('login') }}">ورود | ثبت نام</a>
@endauth
