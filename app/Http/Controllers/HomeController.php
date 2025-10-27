<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.web.index');
    }

    public function category(Category $category)
    {
        $category->load(['children', 'parent']);

        // در آینده محصولات هم:
        // $products = $category->products()->paginate(10);

        return view('pages.web.category', compact('category'));
    }


    private function HeaderCategories()
    {
        return  Category::with('children.children')->whereNull('parent_id')->get();
    }
}
