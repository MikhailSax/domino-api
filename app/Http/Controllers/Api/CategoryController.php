<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return \App\Models\Category::query()
            ->where('is_active', true)
            ->orderBy('sort')
            ->orderBy('title')
            ->get(['id','title','slug']);
    }
}
