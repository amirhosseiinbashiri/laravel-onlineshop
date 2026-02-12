<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
     public function index()
    {
        $tags = Tag::paginate(10);
        return view('pannel.pages.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(([
            'title' => 'required|string|max:255',
        ]));



        Tag::create($data);

        return redirect()->route('tags.index')->with('success', 'تگ با موفقیت ایجاد شد.');
    }

    public function edit(Tag $tag)
    {
        return view('pannel.pages.tags.edit', compact('tag'));
    }


    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $tag->update($data);

        return redirect()->route('tags.index')->with('success', 'تگ با موفقیت ویرایش شد.');
    }


    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'تگ حذف شد.');
    }
}
