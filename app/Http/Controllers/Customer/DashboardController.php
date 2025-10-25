<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $addresses = Address::where('user_id', $user->id)->get();
        return view('pages.customer.dashboard', compact('user', 'addresses'));
    }
}
