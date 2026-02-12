<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PannelController extends Controller
{
    public function index () {
        return view('pannel.pages.index');
    }
}

