<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index() {
        $categories = $this->HeaderCategories();
        return view('pages.web.index', compact('categories'));
    }


    private function HeaderCategories(){
        return  Category::with('children.children')->whereNull('parent_id')->get();
    }
}
