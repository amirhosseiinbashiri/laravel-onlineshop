<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $variants = $product->variants()->with('values.attribute')->paginate(10);

        return view('pages.admin.variants.index', compact('product', 'variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        $attributes = Attribute::with('values')->get();

        return view('pages.admin.variants.create', compact('product', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|string|unique:product_variants,sku',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_expires_at' => 'nullable|date',
            'image' => 'nullable|string',
            'attribute_values' => 'required|array',
        ]);

        $variant = $product->variants()->create($validated);

        // ثبت ویژگی‌های انتخاب‌شده (attribute_value_id ها)

        $variant->values()->sync($validated['attribute_values']);

        return redirect()
            ->route('products.variants.index', $product)
            ->with('success', 'واریانت جدید با موفقیت ایجاد شد.');
    }

    /**
     * فرم ویرایش واریانت
     */


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
    public function edit(Product $product, ProductVariant $variant)
    {
        $attributes = Attribute::with('values')->get();

        // بررسی اینکه واریانت مربوط به همین محصوله
        abort_if($variant->product_id !== $product->id, 404);

        $selected_values = $variant->values()->pluck('attribute_value_id')->toArray();

        return view('pages.admin.variants.edit', compact('product', 'variant', 'attributes', 'selected_values'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        abort_if($variant->product_id !== $product->id, 404);

        $validated = $request->validate([
            'sku' => 'required|string|unique:product_variants,sku,' . $variant->id,
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_expires_at' => 'nullable|date',
            'image' => 'nullable|string',
            'attribute_values' => 'required|array',
        ]);

        $variant->update($validated);

        $variant->values()->sync($validated['attribute_values']);

        return redirect()
            ->route('products.variants.index', $product)
            ->with('success', 'واریانت با موفقیت بروزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductVariant $variant)
    {
        abort_if($variant->product_id !== $product->id, 404);

        $variant->delete();

        return redirect()
            ->route('products.variants.index', $product)
            ->with('success', 'واریانت حذف شد.');
    }
}
