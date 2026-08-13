<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
{
   public function index()
{
    $products = \App\Models\Product::orderBy('sort_order')->get();

    return view('pages.vendor', compact('products'));
}
}