@extends('main.layouts.master')

@section('title', 'کامنت')

@section('content')
    <h3>نظرات کاربران</h3>

    @foreach ($product->comments as $comment)
        <div class="border rounded p-3 mb-3">
            <div class="flex items-center gap-2">
                <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : asset('images/default-avatar.png') }}"
                    class="w-10 h-10 rounded-full">
                <div>
                    <strong>{{ $comment->user->name }}</strong>
                    <div class="text-yellow-500">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa{{ $i <= $comment->rating ? 's' : 'r' }} fa-star"></i>
                        @endfor
                    </div>
                </div>
            </div>
            <h4 class="mt-2 font-bold">{{ $comment->title }}</h4>
            <p>{{ $comment->body }}</p>

            {{-- ریپلای‌ها --}}
            @foreach ($comment->replies as $reply)
                <div class="ml-6 mt-2 border-l pl-3">
                    <strong>{{ $reply->user->name }}</strong> پاسخ داد:
                    <p>{{ $reply->body }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
    <hr>
    <br>
    <br>
    <br>
    <br>
    <br>

    @if (auth()->check())
        <form method="POST" action="{{ route('comments.store', $product) }}" class="mt-4">
            @csrf
            <input type="text" name="title" placeholder="عنوان نظر" class="w-full border rounded p-2 mb-2">
            <textarea name="body" placeholder="متن نظر" rows="4" class="w-full border rounded p-2 mb-2"></textarea>

            <label>امتیاز شما:</label>
            <select name="rating" class="border rounded p-2 mb-2">
                <option value="">بدون امتیاز</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                @endfor
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">ثبت نظر</button>
        </form>
    @else
        <p class="text-gray-600">برای ثبت نظر باید <a href="{{ route('login') }}" class="text-blue-500 underline">وارد
                شوید</a>.</p>
    @endif

@endsection
