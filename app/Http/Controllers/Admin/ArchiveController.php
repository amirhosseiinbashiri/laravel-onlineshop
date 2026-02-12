<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $archives = Archive::latest()->paginate(10);
        return view('pannel.pages.archive.index', compact('archives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pannel.pages.archive.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Archive::create([
            'title' => $request->title
        ]);

        return redirect()->route('archives.index')->with('success', 'ارشیو با موفقیت ایجاد شد');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return true;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Archive $archive)
    {
        return view('pannel.pages.archive.edit', compact('archive'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Archive $archive)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $archive->update([
            'title' => $request->title,
        ]);

        return redirect()->route('archives.index')->with('success', 'آرشیو بروزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Archive $archive)
    {
        $archive->delete();

        return back()->with('success', 'آرشیو حذف شد.');
    }
}
