<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * لیست محصولات
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('pannel.pages.products.index', compact('products'));
    }

    /**
     * فرم ایجاد محصول
     */
    public function create()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $tags = Tag::all();

        return view('pannel.pages.products.create', compact('categories', 'tags'));
    }

    /**
     * ذخیره محصول جدید
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_ends_at' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // ذخیره عکس شاخص
        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        // تولید slug در صورت نبود
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $product = Product::create($validated);

        // ذخیره چند عکس
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $product->images()->create([
                    'path' => $file->store('products/gallery', 'public'),
                ]);
            }
        }

        // اتصال تگ‌ها
        if (!empty($validated['tags'])) {
            $product->tags()->attach($validated['tags']);
        }

        return redirect()->route('products.index')->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    /**
     * فرم ویرایش
     */
    public function edit(Product $product)
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $tags = Tag::all();

        return view('pannel.pages.products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     * بروزرسانی محصول
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_ends_at' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);


        // 🖼 حذف تصویر شاخص
        if ($request->has('remove_main_image') && $product->main_image) {
            Storage::delete('public/' . $product->main_image);
            $product->update(['main_image' => null]);
        }

        // اگر عکس جدید آپلود شد، قبلی حذف شود
        if ($request->hasFile('main_image')) {
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $validated['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product->update($validated);

        // 🗑 حذف تصاویر از گالری
        if ($request->filled('remove_images')) {
            $imagesToRemove = ProductImage::whereIn('id', $request->remove_images)->get();
            foreach ($imagesToRemove as $img) {
                Storage::delete('public/' . $img->path);
                $img->delete();
            }
        }

        // اضافه کردن عکس‌های جدید
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $product->images()->create([
                    'path' => $file->store('products/gallery', 'public'),
                ]);
            }
        }

        // 🏷 بروزرسانی تگ‌ها
        if ($request->filled('tags')) {
            $product->tags()->sync($request->tags);
        } else {
            $product->tags()->detach();
        }

        return redirect()->route('products.index')->with('success', 'محصول با موفقیت بروزرسانی شد.');
    }


    public function show(Product $product)
    {
        $product->load(['comments.replies.user', 'comments.user']);

        return view('pages.products.show', compact('product'));
    }
    /**
     * حذف محصول
     */
    public function destroy(Product $product)
    {
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'محصول حذف شد.');
    }
}
