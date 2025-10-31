@extends('pannel.layouts.master')

@section('title', 'ایجاد دسته جدید')

@section('content')
<h2 class="text-xl font-bold mb-4">ایجاد دسته جدید</h2>

<form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" placeholder="عنوان دسته" class="w-full border p-2 mb-3">

    <select name="parent_id" class="w-full border p-2 mb-3">
        <option value="">بدون والد</option>
        @foreach($parents as $parent)
            <option value="{{ $parent->id }}">{{ $parent->title }}</option>
        @endforeach
    </select>

    <input type="text" name="icon" placeholder="آیکون (اختیاری)" class="w-full border p-2 mb-3">

    <textarea name="description" placeholder="توضیحات (اختیاری)" class="w-full border p-2 mb-3"></textarea>

    <input type="file" name="image" class="w-full border p-2 mb-3">

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">ذخیره دسته</button>
</form>
@endsection
