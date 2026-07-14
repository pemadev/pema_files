<?php

namespace App\Http\Controllers\Ppid;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin-panel.pages.dashboard.ecommerce', ['title' => 'Dashboard PPID']);
    }
}
