<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(\Illuminate\Http\Request $r)
    {
        $q = trim((string) $r->query('q', ''));
        $categorySlug = (string) $r->query('category', '');

        return \App\Models\Product::query()
            ->where('is_active', true)
            ->when($categorySlug !== '', function ($qq) use ($categorySlug) {
                $qq->whereHas('category', fn($c) => $c->where('slug', $categorySlug));
            })
            ->when($q !== '', fn($qq) => $qq->where('title', 'like', "%{$q}%"))
            ->orderBy('title')
            ->get(['id','category_id','title','slug','description','price_from','image_url']);
    }

    public function show(string $slug)
    {
        return \App\Models\Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail(['id','category_id','title','slug','description','price_from','image_url']);
    }

}
