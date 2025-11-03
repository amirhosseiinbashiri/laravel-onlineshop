<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{

    public function index()
    {
        return view('main.pages.home');
    }

    public function about()
    {
        return view('main.pages.about');
    }

    public function category(Category $category)
    {
        $categories = $this->HeaderCategories(); // برای هدر
        $category->load(['children.children']);  // لود زیر‌دسته‌ها تا دو سطح

        // گرفتن همه آیدی‌ها (دسته + زیر‌دسته‌ها)
        $categoryIds = $this->getAllCategoryIds($category);

        // واکشی محصولات مربوط به دسته‌ها
        $products = Product::whereIn('category_id', $categoryIds)->get();

        return view('main.pages.category', compact('category', 'products', 'categories'));
    }


    public function product(Product $product)
    {
        // محصولات مرتبط در دسته خودش یا والد
        $categoryIds = [$product->category_id];
        if ($product->category->parent_id) {
            $categoryIds[] = $product->category->parent_id;
        }

        $relatedProducts = Product::whereIn('category_id', $categoryIds)
            ->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        return view('main.pages.product', compact('product', 'relatedProducts'));
    }

    public function products(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        // فیلتر بر اساس دسته
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // فیلتر بر اساس قیمت
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // سرچ بر اساس عنوان
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('main.pages.products', compact('products', 'categories'));
    }



    private function HeaderCategories()
    {
        return  Category::with('children.children')->whereNull('parent_id')->get();
    }

    private function getAllCategoryIds(Category $category)
    {
        $ids = collect([$category->id]);

        foreach ($category->children as $child) {
            $ids = $ids->merge($this->getAllCategoryIds($child));
        }

        return $ids;
    }
}
