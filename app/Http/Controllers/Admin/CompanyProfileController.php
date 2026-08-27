<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;

class CompanyProfileController extends Controller
{
    public function edit()
    {
        // Get the first profile, or create an empty one if none exists
        $profile = CompanyProfile::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'PT Wiratama Mitra Abadi',
                'about_us' => 'Default about us...',
                'address' => 'Default address...',
                'email' => 'admin@wiratama-ma.com',
                'phone' => '+62',
            ]
        );

        return view('admin.company-profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = CompanyProfile::findOrFail(1);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'about_us' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'company_values' => 'nullable|string',
            'company_history' => 'nullable|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'whatsapp' => 'nullable|string',
            'youtube' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'maps_embed' => 'nullable|string',
            'hero_title' => 'nullable|string',
            'hero_subtitle' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'about_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'about_title' => 'nullable|string',
            'about_summary' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'google_analytics' => 'nullable|string',
            'contact_title' => 'nullable|string',
            'contact_subtitle' => 'nullable|string',
            'about_page_title' => 'nullable|string',
            'about_page_subtitle' => 'nullable|string',
        ]);

        // Sanitize rich text fields if user deleted text but editor left empty HTML tags or null
        $richTextFields = ['about_us', 'vision', 'mission', 'company_values', 'company_history'];
        foreach ($richTextFields as $field) {
            if (array_key_exists($field, $validatedData)) {
                $val = $validatedData[$field] ?? '';
                $plain = trim(strip_tags($val, '<img><iframe><svg>'));
                if ($plain === '' || strtolower($plain) === '&nbsp;') {
                    $validatedData[$field] = '';
                }
            }
        }

        // Handle JSON arrays for stats and features
        $stats = [];
        if ($request->has('stats_number') && $request->has('stats_label')) {
            foreach ($request->stats_number as $index => $number) {
                if (!empty($number) || !empty($request->stats_label[$index])) {
                    $stats[] = [
                        'number' => $number,
                        'label' => $request->stats_label[$index] ?? ''
                    ];
                }
            }
        }
        $validatedData['stats'] = $stats;

        $features = [];
        if ($request->has('features_title') && $request->has('features_desc')) {
            foreach ($request->features_title as $index => $title) {
                if (!empty($title) || !empty($request->features_desc[$index])) {
                    $features[] = [
                        'title' => $title,
                        'desc' => $request->features_desc[$index] ?? ''
                    ];
                }
            }
        }
        $validatedData['features'] = $features;

        // Handle Images
        if ($request->hasFile('hero_image')) {
            if ($profile->hero_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->hero_image);
            }
            $validatedData['hero_image'] = $request->file('hero_image')->store('landing', 'public');
        }

        if ($request->hasFile('about_image')) {
            if ($profile->about_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->about_image);
            }
            $validatedData['about_image'] = $request->file('about_image')->store('landing', 'public');
        }

        if ($request->hasFile('about_images')) {
            $images = [];
            // Preserve existing images if any
            if ($profile->about_images && is_array($profile->about_images)) {
                $images = $profile->about_images;
            }
            
            foreach ($request->file('about_images') as $file) {
                $images[] = $file->store('landing/about', 'public');
            }
            $validatedData['about_images'] = $images;
        }

        if ($request->has('remove_about_images') && is_array($request->remove_about_images)) {
            $existing = $profile->about_images ?? [];
            foreach ($request->remove_about_images as $path) {
                if (($key = array_search($path, $existing)) !== false) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
                    unset($existing[$key]);
                }
            }
            $validatedData['about_images'] = array_values($existing);
        }

        $profile->update($validatedData);

        return redirect()->back()->with('success', 'Company Profile & Landing Page updated successfully!');
    }
}
