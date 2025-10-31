<header class="bg-white shadow-sm flex items-center justify-between px-6 py-2 shadow-md z-10">
    <h1 class="text-sm font-semibold text-gray-800 flex gap-3">
        <span>{{ auth()->user()->username }}</span>خوش آمدید<span></span>
    </h1>
    <div class="flex items-center gap-4">
        <a class="bg-blue-500 rounded-md py-1 px-3 text-sm font-bold text-white"  href="{{ route('home') }}">رفتن به سایت</a>
        <a class="bg-blue-500 rounded-md py-1 px-3 text-sm font-bold text-white"  href="{{ route('dashboard') }}">رفتن به پنل مشتری</a>
    </div>
</header>
