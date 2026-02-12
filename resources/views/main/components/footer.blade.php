<footer class="bg-gray-900 text-gray-200 mt-20" dir="rtl">
    <div class="max-w-[1260px] mx-auto">
        <div class="container mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-10">

            {{-- بخش درباره سایت --}}
            <div class="text-right">
                <h3 class="text-xl font-bold text-white mb-4">درباره ما</h3>
                <p class="text-gray-400 leading-relaxed">
                    این فروشگاه به صورت محور ساخته شده تا بهترین تجربه خرید آنلاین را برای شما فراهم کند.
                    کیفیت، نوآوری و رضایت مشتری در اولویت ماست.
                </p>
            </div>

            {{-- لینک‌های سریع --}}
            <div class="text-right">
                <h3 class="text-xl font-bold text-white mb-4">لینک‌های سریع</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition">خانه</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-blue-400 transition">درباره ما</a></li>
                    <li><a href="" class="hover:text-blue-400 transition">دسته‌بندی محصولات</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">تماس با ما</a></li>
                </ul>
            </div>

            {{-- دسته‌بندی‌ها --}}
            <div class="text-right">
                <h3 class="text-xl font-bold text-white mb-4">دسته‌بندی‌ها</h3>
                <ul class="space-y-2">
                    @foreach (\App\Models\Category::whereNull('parent_id')->take(5)->get() as $category)
                        <li>
                            <a href="{{ route('category', $category->slug) }}" class="hover:text-blue-400 transition">
                                {{ $category->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- شبکه‌های اجتماعی --}}
            <div class="text-right">
                <h3 class="text-xl font-bold text-white mb-4">ما را دنبال کنید</h3>
                <div class="flex gap-4 justify-end">
                    <a href="#" class="hover:text-blue-500 transition text-2xl"><i
                            class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-blue-400 transition text-2xl"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-pink-500 transition text-2xl"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-red-600 transition text-2xl"><i class="fab fa-youtube"></i></a>
                </div>
                <p class="text-gray-400 mt-4 text-sm">خبرنامه ما را دنبال کنید تا هیچ پیشنهاد ویژه‌ای را از دست ندهید.
                </p>
                <form action="#" class="mt-2 flex gap-2 justify-end">
                    <input type="email" placeholder="ایمیل خود را وارد کنید"
                        class="w-full px-3 py-2 rounded-lg text-gray-900">
                    <button type="submit"
                        class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition">عضویت</button>
                </form>
            </div>

        </div>

        <div class="border-t border-gray-800 mt-8 py-4 text-center text-gray-500 text-sm">
            © 2025 تمامی حقوق محفوظ است | طراحی شده با ❤️ توسط تیم شما
        </div>
    </div>

</footer>
