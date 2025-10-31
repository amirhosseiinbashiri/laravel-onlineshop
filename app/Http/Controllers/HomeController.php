<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{

    public function index()
    {
        return view('main.pages.home');
    }

    public function category(Category $category)
    {
        $category->load(['children', 'parent']);
        return view('main.pages.category', compact('category'));
    }


    private function HeaderCategories()
    {
        return  Category::with('children.children')->whereNull('parent_id')->get();
    }
}
