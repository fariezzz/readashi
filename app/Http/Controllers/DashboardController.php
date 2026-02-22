<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(){
        return view('pages.index', [
            'title' => 'Dashboard',
            'users' => User::all(),
            'products' => Product::all()
        ]);
    }
}
