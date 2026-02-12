@extends('pannel.layouts.master')

@section('title', 'ایجاد  تگ جدید')

@section('content')
<h2 class="text-xl font-bold mb-4">ایجاد نگ جدید</h2>

<form method="POST" action="{{ route('tags.store') }}">
    @csrf
    <input type="text" name="title" placeholder="عنوان نگ" class="w-full border p-2 mb-3">

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">ذخیره نگ</button>
</form>
@endsection
