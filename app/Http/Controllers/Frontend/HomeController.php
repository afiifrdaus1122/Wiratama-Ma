<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Models\HighlightEvent;

class HomeController extends Controller
{
    public function index()
    {
        $company = CompanyProfile::first();
        $highlight = HighlightEvent::where('expires_at', '>=', now())->latest()->first();
        $latestArticles = \App\Models\Article::with('category')->latest()->take(5)->get();
        $galleries = \App\Models\Gallery::latest()->take(8)->get();
        $latestProducts = \App\Models\Product::where('is_active', true)->with('category')->latest()->take(12)->get();
        $heroBanners = \App\Models\HeroBanner::where('page', 'home')
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->orderBy('sort_order')
            ->get();
        $clientLogos = \App\Models\ClientLogo::where('is_active', true)->orderBy('order')->get();
        $categories = \App\Models\Category::where('name', 'NOT LIKE', '%Oil Skimmer%')->withCount('products')->get();
        
        return view('welcome', compact('company', 'highlight', 'latestArticles', 'galleries', 'latestProducts', 'clientLogos', 'heroBanners', 'categories'));
    }

    public function about()
    {
        $company = CompanyProfile::first();
        $teams = \App\Models\Team::latest()->get();
        return view('frontend.about', compact('company', 'teams'));
    }
}
