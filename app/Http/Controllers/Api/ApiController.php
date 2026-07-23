<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class ApiController extends Controller
{
    public function berita()
    {

        $newsList = News::type('berita')
            ->where('is_published', true)
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(request()->query());

        return response()->json($newsList);
    }
}
