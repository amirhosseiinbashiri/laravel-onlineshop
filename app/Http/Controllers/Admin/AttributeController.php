<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::latest()->paginate(10);
        return view('pages.admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:attributes,name'],
            'filterable' => ['boolean'],
        ]);

        Attribute::create([
            'name' => $request->name,
            'filterable' => $request->boolean('filterable'),
        ]);

        return redirect()->route('attributes.index')
            ->with('success', 'ویژگی جدید با موفقیت ایجاد شد.');
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
    public function edit(Attribute $attribute)
    {
        return view('pages.admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:attributes,name,' . $attribute->id],
            'filterable' => ['boolean'],
        ]);

        $attribute->update([
            'name' => $request->name,
            'filterable' => $request->boolean('filterable'),
        ]);

        return redirect()->route('attributes.index')
            ->with('success', 'ویژگی با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('attributes.index')
            ->with('success', 'ویژگی حذف شد.');
    }
}
