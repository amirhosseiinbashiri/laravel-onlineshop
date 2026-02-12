<div class="w-full flex items-center gap-3 py-3 overflow-hidden">
    @foreach ($categories as $category)
        <a href="{{ route('category', [$category->slug]) }}" class="py-1 px-1 rounded-full flex justify-between items-center gap-4 shadow-md pr-3 cursor-pointer" >
            @if(isset($category->image))
                <img class="w-[35px] h-[35px] rounded-full" src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->title }}">
            @else
                <div class="w-[35px] h-[35px] rounded-full"></div>
            @endif
            <span class="text-md font-bold">{{ $category->title }}</span>
        </a>
    @endforeach
</div>
