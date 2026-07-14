<?php

namespace App\Http\Controllers\Ppid;

use App\Http\Controllers\Controller;

class PpidController extends Controller
{

    public function index()
    {
        return view('admin-panel.pages.tables.basic-tables', ['title' => 'Daftar Pengguna PPID']);
    }
}
