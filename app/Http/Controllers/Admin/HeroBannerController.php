<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::orderBy('sort_order')->get();
        return view('admin.hero_banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.hero_banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'desktop_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'background_type' => 'required|in:image,color,gradient',
            'background_value' => 'nullable|string|max:255',
            'cta_text' => 'nullable|string|max:255',
            'cta_url' => 'nullable|string|max:255',
            'cta_target' => 'required|in:_self,_blank',
            'overlay_color' => 'nullable|string|max:20',
            'overlay_opacity' => 'required|numeric|min:0|max:1',
            'position' => 'required|in:left,center,right',
            'height_vh' => 'required|integer|min:10|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('desktop_image')) {
            $validated['desktop_image'] = $request->file('desktop_image')->store('hero_banners', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            $validated['mobile_image'] = $request->file('mobile_image')->store('hero_banners', 'public');
        }

        HeroBanner::create($validated);

        return redirect()->route('admin.hero-banners.index')->with('success', 'Hero Banner created successfully.');
    }

    public function edit(HeroBanner $heroBanner)
    {
        return view('admin.hero_banners.edit', compact('heroBanner'));
    }

    public function update(Request $request, HeroBanner $heroBanner)
    {
        $validated = $request->validate([
            'page' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'desktop_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'background_type' => 'required|in:image,color,gradient',
            'background_value' => 'nullable|string|max:255',
            'cta_text' => 'nullable|string|max:255',
            'cta_url' => 'nullable|string|max:255',
            'cta_target' => 'required|in:_self,_blank',
            'overlay_color' => 'nullable|string|max:20',
            'overlay_opacity' => 'required|numeric|min:0|max:1',
            'position' => 'required|in:left,center,right',
            'height_vh' => 'required|integer|min:10|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('desktop_image')) {
            if ($heroBanner->desktop_image) {
                Storage::disk('public')->delete($heroBanner->desktop_image);
            }
            $validated['desktop_image'] = $request->file('desktop_image')->store('hero_banners', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            if ($heroBanner->mobile_image) {
                Storage::disk('public')->delete($heroBanner->mobile_image);
            }
            $validated['mobile_image'] = $request->file('mobile_image')->store('hero_banners', 'public');
        }

        $heroBanner->update($validated);

        return redirect()->route('admin.hero-banners.index')->with('success', 'Hero Banner updated successfully.');
    }

    public function destroy(HeroBanner $heroBanner)
    {
        if ($heroBanner->desktop_image) Storage::disk('public')->delete($heroBanner->desktop_image);
        if ($heroBanner->mobile_image) Storage::disk('public')->delete($heroBanner->mobile_image);
        
        $heroBanner->delete();

        return redirect()->route('admin.hero-banners.index')->with('success', 'Hero Banner deleted successfully.');
    }
}
