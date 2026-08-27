<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $galleryCategories = Gallery::whereNotNull('gallery_category')->distinct()->pluck('gallery_category');
        
        $query = Gallery::latest();
        
        if ($request->filled('category')) {
            $query->where('gallery_category', $request->category);
        }
        
        $galleries = $query->paginate(16)->appends($request->all());
        
        return view('frontend.galleries.index', compact('galleries', 'galleryCategories'));
    }
}
