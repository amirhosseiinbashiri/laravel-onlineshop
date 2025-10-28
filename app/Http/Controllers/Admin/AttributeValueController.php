<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Attribute $attribute)
    {
        $values = $attribute->values()->latest()->get();
        return view('pages.admin.attribute_values.index', compact('attribute', 'values'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Attribute $attribute)
    {
        return view('pages.admin.attribute_values.create', compact('attribute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Attribute $attribute)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $attribute->values()->create([
            'value' => $request->value,
        ]);

        return redirect()->route('attributes.values.index', $attribute->id)
            ->with('success', 'مقدار جدید با موفقیت اضافه شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute, AttributeValue $value)
    {
        return view('pages.admin.attribute_values.edit', compact('attribute', 'value'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute, AttributeValue $value)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $value->update(['value' => $request->value]);

        return redirect()->route('attributes.values.index', $attribute->id)
            ->with('success', 'مقدار با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute, AttributeValue $value)
    {
        $value->delete();
        return back()->with('success', 'مقدار با موفقیت حذف شد.');
    }
}
