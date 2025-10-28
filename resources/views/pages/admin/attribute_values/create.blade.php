@extends('layouts.admin')

@section('title', 'افزودن مقدار برای ' . $attribute->name)

@section('content')
    <h2>افزودن مقدار برای "{{ $attribute->name }}"</h2>

    <form method="POST" action="{{ route('attributes.values.store', $attribute->id) }}">
        @csrf
        <div class="mb-3">
            <label for="value" class="block mb-1">مقدار</label>
            <input type="text" name="value" id="value" class="w-full border p-2 rounded">
            @error('value')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">افزودن</button>
    </form>
@endsection
