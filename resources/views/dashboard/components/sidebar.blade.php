    <aside class="w-64 h-full bg-white shadow-md hidden md:flex flex-col">
        <div class="py-2.5 border-b-2 border-gray-300">
            <h2 class="text-md font-bold text-center"><a href="{{ route('dashboard') }}">داشبورد</a> </h2>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('profile.show') }}" class="transition-all duration-300 border-r-2 border-amber-400 text-center font-semibold block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-500 hover:text-white">پروفایل</a>
            <a href="{{ route('addresses.index') }}" class="transition-all duration-300 border-r-2 border-amber-400 text-center font-semibold block px-3 py-2 rounded-lg text-gray-700 hover:bg-amber-500 hover:text-white">آدرس ها</a>
        </nav>

        <div class="p-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full text-center px-3 py-2 cursor-pointer bg-red-500 rounded-md text-white font-bold">خروج</button>
            </form>
        </div>
    </aside>
