<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Blog;
use App\Models\Pin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('archive', 'author')->latest()->paginate(10);
        return view('pannel.pages.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $archives = Archive::all();
        $pins = Pin::all();
        return view('pannel.pages.blog.create', compact('archives', 'pins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'archive_id' => 'required|exists:archives,id',
            'summary' => 'nullable|string',
            'body' => 'required|string',
            'main_image' => 'nullable|image|max:2048',
            'pins' => 'nullable|array',
        ]);

        $data = $request->only(['archive_id', 'title', 'summary', 'body']);
        $data['user_id'] = Auth::id();
        $data['is_published'] = $request->has('is_published');

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('blogs', 'public');
        }

        $blog = Blog::create($data);

        if ($request->pins) {
            $blog->pins()->attach($request->pins);
        }

        return redirect()->route('blogs.index')->with('success', 'مقاله با موفقیت ایجاد شد.');
    }




    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('pannel.pages.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $archives = Archive::all();
        $pins = Pin::all();
        return view('pannel.pages.blog.edit', compact('blog', 'archives', 'pins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'archive_id' => 'required|exists:archives,id',
            'summary' => 'nullable|string',
            'body' => 'required|string',
            'main_image' => 'nullable|image|max:2048',
            'pins' => 'nullable|array',
        ]);

        $data = $request->only(['archive_id', 'title', 'summary', 'body']);
        $data['is_published'] = $request->has('is_published');

        if ($request->hasFile('main_image')) {
            if ($blog->main_image) {
                Storage::disk('public')->delete($blog->main_image);
            }
            $data['main_image'] = $request->file('main_image')->store('blogs', 'public');
        }

        $blog->update($data);
        $blog->pins()->sync($request->pins ?? []);

        return redirect()->route('blogs.index')->with('success', 'مقاله بروزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->main_image) {
            Storage::disk('public')->delete($blog->main_image);
        }

        $blog->delete();

        return back()->with('success', 'مقاله حذف شد.');
    }
}
