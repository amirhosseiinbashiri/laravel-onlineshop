<a href="{{ route('blog', $blog->slug) }}"
    class="block bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
    @if ($blog->main_image)
        <img src="{{ asset('storage/' . $blog->main_image) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
    @endif

    <div class="p-4 space-y-2">
        <h2 class="font-semibold text-lg text-gray-800 line-clamp-2">{{ $blog->title }}</h2>
        <p class="text-sm text-gray-500 line-clamp-3">{{ $blog->summary }}</p>
        <div class="flex items-center justify-between text-xs text-gray-400 mt-2">
            <span>{{ jdate($blog->created_at)->format('Y/m/d') }}</span>
            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ $blog->archive->title ?? 'بدون دسته' }}</span>
        </div>
    </div>
</a>
