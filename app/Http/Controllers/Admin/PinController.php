<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pin;
use Illuminate\Http\Request;

class PinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pins = Pin::latest()->paginate(10);
        return view('pannel.pages.pin.index', compact('pins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pannel.pages.pin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:pins,name'
        ]);

        Pin::create(['name' => $request->name]);

        return redirect()->route('pins.index')->with('success', 'تگ جدید ایجاد شد.');
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
    public function edit(Pin $pin)
    {
        return view('pannel.pages.pin.edit', compact('pin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pin $pin)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:pins,name,' . $pin->id,
        ]);

        $pin->update(['name' => $request->name]);

        return redirect()->route('pins.index')->with('success', 'تگ بروزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pin $pin)
    {
        $pin->delete();

        return back()->with('success', 'تگ حذف شد.');
    }
}
