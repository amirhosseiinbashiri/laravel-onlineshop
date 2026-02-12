@extends('pannel.layouts.master')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
<div class="min-h-screen bg-gray-50 p-6 flex justify-center">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 w-full max-w-3xl">

        {{-- عنوان --}}
        <div class="flex items-center justify-between mb-8 border-b pb-3">
            <h2 class="text-2xl font-bold text-gray-800">ویرایش دسته‌بندی</h2>
            <a href="{{ route('categories.index') }}"
               class="text-sm text-blue-600 hover:text-blue-800 transition">← بازگشت به لیست</a>
        </div>

        {{-- فرم --}}
        <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- عنوان دسته --}}
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-1">عنوان دسته</label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $category->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- دسته والد --}}
            <div>
                <label for="parent_id" class="block text-gray-700 font-semibold mb-1">زیرمجموعه‌ی</label>
                <select name="parent_id" id="parent_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">بدون والد</option>
                    @foreach ($parents as $cat)
                        <option value="{{ $cat->id }}" {{ $cat->id == $category->parent_id ? 'selected' : '' }}>
                            {{ $cat->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- آیکون --}}
            <div>
                <label for="icon" class="block text-gray-700 font-semibold mb-1">آیکون (اختیاری)</label>
                <input type="text" name="icon" id="icon"
                       value="{{ old('icon', $category->icon) }}"
                       placeholder="مثلاً fa-solid fa-phone یا 👕"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- تصویر --}}
            <div>
                <label for="image" class="block text-gray-700 font-semibold mb-2">تصویر دسته</label>

                @if ($category->image)
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ asset('storage/' . $category->image) }}"
                             alt="تصویر دسته"
                             class="w-24 h-24 object-cover rounded-xl border border-gray-200 shadow-sm">
                        <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                            <input type="checkbox" name="remove_image" value="1" class="w-4 h-4">
                            <span>حذف تصویر فعلی</span>
                        </label>
                    </div>
                @endif

                <input type="file" name="image" id="image"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       accept="image/*" onchange="previewImage(event)">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                {{-- پیش‌نمایش تصویر جدید --}}
                <div id="image-preview" class="mt-3 hidden">
                    <p class="text-gray-600 text-sm mb-1">پیش‌نمایش تصویر جدید:</p>
                    <img id="preview" src="#" alt="پیش‌نمایش" class="w-24 h-24 object-cover rounded-lg border">
                </div>
            </div>

            {{-- توضیحات --}}
            <div>
                <label for="description" class="block text-gray-700 font-semibold mb-1">توضیحات (اختیاری)</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                          placeholder="توضیح کوتاه برای این دسته...">{{ old('description', $category->description) }}</textarea>
            </div>

            {{-- دکمه‌ها --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('categories.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold transition">
                    انصراف
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                    ذخیره تغییرات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
function previewImage(event) {
    const previewContainer = document.getElementById('image-preview');
    const preview = document.getElementById('preview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
