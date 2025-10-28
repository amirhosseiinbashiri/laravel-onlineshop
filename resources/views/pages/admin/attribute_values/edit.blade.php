@extends('layouts.admin')

@section('title', 'ویرایش مقدار ' . $value->value)

@section('content')
    <h2>ویرایش مقدار "{{ $attribute->name }}"</h2>

    <form method="POST" action="{{ route('attributes.values.update', [$attribute->id, $value->id]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="value" class="block mb-1">مقدار</label>
            <input type="text" name="value" id="value" class="w-full border p-2 rounded"
                   value="{{ old('value', $value->value) }}">
            @error('value')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">ذخیره تغییرات</button>
    </form>
@endsection
