@extends('main.layouts.master')

@section('title', $product->title)

@section('style')
    <style>
        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: #facc15;
            /* رنگ طلایی Tailwind-yellow-400 */
        }

        /* ستاره‌های قبل از checked هم طلایی می‌شوند */
        .rating input:checked+label,
        .rating input:checked+label~label {
            color: #facc15;
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto mt-10 px-4" dir="rtl">

        {{-- بخش بالای محصول --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white shadow-lg rounded-2xl p-6">
            {{-- تصاویر --}}
            <div>
                <div class="overflow-hidden rounded-2xl shadow-sm mb-4">
                    <img id="mainImage" src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->title }}"
                        class="w-full h-96 object-cover transition-transform duration-300 hover:scale-105">
                </div>

                @if ($product->images && $product->images->count())
                    <div class="flex gap-3 flex-wrap">
                        @foreach ($product->images as $image)
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->alt ?? $product->title }}"
                                class="w-20 h-20 object-cover rounded-lg border hover:scale-105 transition cursor-pointer gallery-thumb"
                                data-full="{{ asset('storage/' . $image->path) }}">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- اطلاعات محصول --}}
            <div class="flex flex-col justify-between text-right">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->title }}</h1>

                @if ($product->short_description)
                    <p class="text-gray-600 leading-relaxed mb-6">{{ $product->short_description }}</p>
                @endif

                <div class="mb-6">
                    @if ($product->discount_price)
                        <div class="flex items-center gap-3">
                            <span class="text-gray-400 line-through text-lg">{{ number_format($product->price) }}
                                تومان</span>
                            <span class="text-red-600 text-2xl font-bold">{{ number_format($product->discount_price) }}
                                تومان</span>
                        </div>

                        @if ($product->discount_ends_at)
                            <p class="text-sm text-gray-500 mt-2">
                                تخفیف تا {{ jdate($product->discount_ends_at)->format('Y/m/d H:i') }}
                            </p>
                        @endif
                    @else
                        <span class="text-blue-600 text-2xl font-bold">{{ number_format($product->price) }} تومان</span>
                    @endif
                </div>

                <div class="mt-4">
                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow transition">
                        افزودن به سبد خرید 🛒
                    </button>
                </div>

                <div class="mt-6 text-sm text-gray-500">
                    <span>دسته: </span>
                    <a href="{{ route('category', $product->category->slug) }}" class="text-blue-600 hover:underline">
                        {{ $product->category->title }}
                    </a>
                </div>
            </div>
        </div>

        {{-- تب‌ها: توضیحات و نظرات --}}
        <div class="mt-10 bg-white shadow-md rounded-2xl p-6">
            <div class="flex border-b mb-4">
                <button class="tab-btn px-4 py-2 border-b-2 border-blue-500 font-semibold text-blue-600"
                    data-tab="description">توضیحات</button>
                <button class="tab-btn px-4 py-2 text-gray-600 font-semibold" data-tab="reviews">نظرات</button>
            </div>

            <div id="description" class="tab-content">
                {!! nl2br(e($product->description)) !!}
            </div>

            <div id="reviews" class="tab-content hidden">
                <div class="space-y-4">
                    {{-- کامنت‌های استاتیک --}}
                    <div class="flex items-start gap-4">
                        <img src="{{ asset('storage/users/default.png') }}" alt="کاربر" class="w-12 h-12 rounded-full">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold">محمد رضایی</span>
                                <div class="flex text-yellow-400">
                                    ★★★★☆
                                </div>
                            </div>
                            <p class="text-gray-700 mt-1">محصول بسیار عالی و با کیفیت بود.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <img src="{{ asset('storage/users/default.png') }}" alt="کاربر" class="w-12 h-12 rounded-full">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold">سارا احمدی</span>
                                <div class="flex text-yellow-400">
                                    ★★★★★
                                </div>
                            </div>
                            <p class="text-gray-700 mt-1">ارسال سریع و بسته‌بندی عالی.</p>
                        </div>
                    </div>
                </div>

                @auth
                    <div class="mt-8 bg-white shadow-md rounded-2xl p-6">
                        <h2 class="text-xl font-bold border-r-4 border-blue-500 pr-3 mb-4">ارسال نظر شما</h2>

                        <form method="POST" action="{{ route('comments.store', $product->id) }}" class="space-y-4">
                            @csrf

                            {{-- عنوان نظر --}}
                            <div>
                                <label for="title" class="block font-medium mb-1">عنوان نظر</label>
                                <input type="text" name="title" id="title" placeholder="عنوان کوتاه برای نظر شما"
                                    class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- متن نظر --}}
                            <div>
                                <label for="body" class="block font-medium mb-1">متن نظر</label>
                                <textarea name="body" id="body" rows="4" placeholder="نظر خود را وارد کنید"
                                    class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                                @error('body')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- امتیاز ستاره‌ای --}}
                            <div>
                                <label class="block font-medium mb-1">امتیاز</label>
                                <div class="flex items-center gap-1 text-gray-400 rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" id="star{{ $i }}"
                                            value="{{ $i }}" class="hidden peer" />
                                        <label for="star{{ $i }}" class="cursor-pointer text-2xl">
                                            ★
                                        </label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- دکمه ارسال --}}
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow transition">
                                ارسال نظر
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-8 bg-white shadow-md rounded-2xl p-6 text-center">
                        <p class="text-gray-700">برای ارسال نظر، لطفاً <a href="{{ route('login') }}"
                                class="text-blue-600 underline">وارد شوید</a>.</p>
                    </div>
                @endauth

            </div>
        </div>

        {{-- محصولات مرتبط --}}
        @if ($relatedProducts->count())
            <div class="mt-10">
                <h2 class="text-xl font-bold mb-4 border-r-4 border-blue-500 pr-3">محصولات مرتبط</h2>
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @foreach ($relatedProducts as $rp)
                        @include('main.components.productCart', ['product' => $rp])
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection

@section('script')
    <script>
        // تعویض تصویر اصلی
        document.querySelectorAll('.gallery-thumb').forEach(img => {
            img.addEventListener('click', function() {
                document.getElementById('mainImage').src = this.dataset.full;
            });
        });

        // تب‌ها
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600'));
                tabs.forEach(t => t.classList.add('text-gray-600'));
                tab.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');

                contents.forEach(c => c.classList.add('hidden'));
                document.getElementById(tab.dataset.tab).classList.remove('hidden');
            });
        });
    </script>
@endsection
ّ
