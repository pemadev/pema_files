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
            ->paginate(10)
            ->appends(request()->query())
            ->orderBy('id', 'desc');

        return response()->json($newsList);
    }
}
