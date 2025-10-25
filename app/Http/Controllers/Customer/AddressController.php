<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('pages.dashboard.addresses.index', compact('addresses'));
    }

    public function create()
    {
        $provinces = $this->getProvinces();
        return view('pages.dashboard.addresses.create', compact('provinces'));
    }

    public function edit($id)
    {
        $address = Address::where('user_id', auth()->id())->findOrFail($id);
        $provinces = $this->getProvinces();
        return view('pages.dashboard.addresses.edit', compact('address', 'provinces'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'province' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'province' => $data['province'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'address' => $data['address'],
        ]);

        return redirect()
            ->route('dashboard.addresses.index')
            ->with('success', 'آدرس با موفقیت اضافه شد.');
    }

    public function update(Request $request, Address $address)
    {
        $data = $request->validate([
            'province' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'required|string',
        ]);

        $address->update($data);

        return redirect()->route('dashboard.addresses.index')
            ->with('success', 'آدرس با موفقیت بروزرسانی شد.');
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return back()->with('success', 'آدرس با موفقیت حذف شد.');
    }

    // apis...
    private function getProvinces()
    {
        $response = Http::get('https://iran-locations-api.ir/api/v1/fa/states');
        if ($response->successful()) {
            return $response->json();
        }
        return [];
    }

    public function getCities($province)
    {
        $response = Http::get("https://iran-locations-api.ir/api/v1/fa/cities?state={$province}");
        if ($response->successful()) {
            return $response->json();
        }
        return [];
    }
}
