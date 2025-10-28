<header class="sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">

        {{-- بخش چپ - لوگو --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('page.home') }}">
                <img src="https://placehold.co/100x40?text=Logo" alt="Logo" class="h-10 object-contain">
            </a>
        </div>

        {{-- بخش وسط - نوار جستجو --}}
        <div class="flex-1 px-6 hidden md:block">
            <div class="relative">
                <input type="text"
                    class="w-full border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="جستجو...">
                <button
                    class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-600 transition-colors">
                </button>
            </div>
        </div>

        {{-- بخش راست --}}
        <div class="flex items-center gap-6">

            {{-- بخش اول: ورود / ثبت نام یا پنل کاربری --}}
            @guest
                <a href="{{ route('register.form') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">
                    ثبت‌نام / ورود
                </a>
            @else
                <a href="{{ route('dashboard') }}"
                    class="border border-blue-600 text-blue-600 px-4 py-2 rounded-full hover:bg-blue-50 transition">
                    پنل کاربری
                </a>
            @endguest

            {{-- بخش دوم: لینک‌ها --}}
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('page.home') }}" class="hover:text-blue-600 transition">خانه</a>

                {{-- دسته‌ها (از کد قبلیت) --}}
                <div class="relative group">
                    <button class="hover:text-blue-600 transition">دسته‌ها</button>

                    <ul class="absolute left-0 mt-2 hidden group-hover:block bg-white shadow-lg rounded p-2 w-48">
                        @foreach ($categories as $category)
                            <li class="relative group">
                                <a href="#"
                                    class="block px-3 py-1 hover:bg-gray-100">
                                    {{ $category->title }}
                                </a>

                                {{-- سطح دوم --}}
                                @if ($category->children->count())
                                    <ul
                                        class="absolute left-full top-0 hidden group-hover:block bg-white shadow-lg rounded p-2 w-48">
                                        @foreach ($category->children as $child)
                                            <li class="relative group">
                                                <a href="{{ route('page.category', $child->slug) }}"
                                                    class="block px-3 py-1 hover:bg-gray-100">
                                                    {{ $child->title }}
                                                </a>

                                                {{-- سطح سوم --}}
                                                @if ($child->children->count())
                                                    <ul
                                                        class="absolute left-full top-0 hidden group-hover:block bg-white shadow-lg rounded p-2 w-48">
                                                        @foreach ($child->children as $subchild)
                                                            <li>
                                                                <a href="{{ route('page.category', $subchild->slug) }}"
                                                                    class="block px-3 py-1 hover:bg-gray-100">
                                                                    {{ $subchild->title }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <a href="#" class="hover:text-blue-600 transition">محصولات</a>
                <a href="#" class="hover:text-blue-600 transition">درباره ما</a>
            </nav>
        </div>
    </div>
</header>
