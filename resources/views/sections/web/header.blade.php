<header>
    <ul class="flex gap-6">
        @foreach ($categories as $category)
            <li class="relative group">
                <a href="#" class="hover:text-blue-600">{{ $category->title }}</a>

                @if ($category->children->count())
                    <ul class="absolute left-0 mt-2 hidden group-hover:block bg-white shadow-lg rounded p-2 w-48">
                        @foreach ($category->children as $child)
                            <li class="relative group">
                                <a href="#" class="block px-3 py-1 hover:bg-gray-100">
                                    {{ $child->title }}
                                </a>

                                {{-- زیر‌دسته‌های سطح سوم --}}
                                @if ($child->children->count())
                                    <ul
                                        class="absolute left-full top-0 hidden group-hover:block bg-white shadow-lg rounded p-2 w-48">
                                        @foreach ($child->children as $subchild)
                                            <li>
                                                <a href="#" class="block px-3 py-1 hover:bg-gray-100">
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

</header>
