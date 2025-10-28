<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')
            ->latest()
            ->paginate(15);

        return view('pages.admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|in:draft,published',
            'base_price'    => 'nullable|numeric|min:0',
            'price'         => 'nullable|numeric',
            'sku'         => 'nullable|string',
            'stock'         => 'nullable|integer|min:0',
            'categories'    => 'nullable|array',
            'type'    => 'required',
            'image'         => 'nullable|image|max:2048',
            'seo_title'     => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        if ($request->categories) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('products.index')->with('success', 'محصول با موفقیت ایجاد شد.');
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
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|in:draft,published',
            'base_price'    => 'nullable|numeric|min:0',
            'sku'         => 'nullable|string',
            'price'         => 'nullable|numeric',
            'stock'         => 'nullable|integer|min:0',
            'categories'    => 'nullable|array',
            'type'    => 'required',
            'image'         => 'nullable|image|max:2048',
            'seo_title'     => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
        ]);


        if ($request->hasFile('image')) {
            // حذف تصویر قبلی
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        $product->categories()->sync($request->categories ?? []);

        return redirect()->route('products.index')->with('success', 'محصول با موفقیت به‌روزرسانی شد.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->categories()->detach();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'محصول حذف شد.');
    }
}
