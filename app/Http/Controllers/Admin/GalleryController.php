<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        $galleryCategories = Gallery::whereNotNull('gallery_category')->distinct()->pluck('gallery_category');
        return view('admin.galleries.create', compact('galleryCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'gallery_category' => 'required|string|max:255',
            'image_path' => 'required|array',
            'image_path.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'description', 'gallery_category']);

        if ($request->hasFile('image_path')) {
            $imagesArray = [];
            foreach ($request->file('image_path') as $file) {
                $imagesArray[] = $file->store('galleries', 'public');
            }
            $data['images'] = $imagesArray;
            // Also store the first image in the 'image' column for backward compatibility/thumbnail
            if (count($imagesArray) > 0) {
                $data['image'] = $imagesArray[0];
            }
        }

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Images added to gallery.');
    }

    public function edit(Gallery $gallery)
    {
        $galleryCategories = Gallery::whereNotNull('gallery_category')->distinct()->pluck('gallery_category');
        return view('admin.galleries.edit', compact('gallery', 'galleryCategories'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'gallery_category' => 'required|string|max:255',
            'image_path' => 'nullable|array',
            'image_path.*' => 'image|max:5120',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'description', 'gallery_category']);

        if ($request->hasFile('image_path')) {
            // Delete old images
            if ($gallery->images) {
                foreach ($gallery->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            } elseif ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }

            $imagesArray = [];
            foreach ($request->file('image_path') as $file) {
                $imagesArray[] = $file->store('galleries', 'public');
            }
            $data['images'] = $imagesArray;
            if (count($imagesArray) > 0) {
                $data['image'] = $imagesArray[0];
            }
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery updated.');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Image deleted.');
    }
}
