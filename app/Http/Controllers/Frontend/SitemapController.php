<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Article;
use App\Models\Category;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->get();
        $articles = Article::where('is_published', true)->latest()->get();
        $categories = Category::all();

        return response()->view('sitemap.index', [
            'products' => $products,
            'articles' => $articles,
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }
}
