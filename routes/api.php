<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\News;
use App\Http\Controllers\Api\ApiController;

Route::middleware('api')->group(function () {
    Route::get('/berita', [ApiController::class, 'berita']);
});
