<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        return view('admin.products.create', compact('categories', 'subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products',
            'category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
            'brand' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'datasheet' => 'nullable|file|mimes:pdf|max:5120',
            'video_url' => 'nullable|url|max:2048',
            'additional_images' => 'nullable|array|max:8',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();
        $data['is_active'] = $request->has('is_active');

        // Handle dynamic category creation
        $categoryId = $request->category_id;
        if (!is_numeric($categoryId)) {
            $newCategory = Category::create([
                'name' => $categoryId,
                'slug' => Str::slug($categoryId) . '-' . uniqid()
            ]);
            $data['category_id'] = $newCategory->id;
        }

        // Handle dynamic sub category creation
        if ($request->filled('sub_category_id')) {
            $subCategoryId = $request->sub_category_id;
            if (!is_numeric($subCategoryId)) {
                $newSubCategory = SubCategory::create([
                    'category_id' => $data['category_id'],
                    'name' => $subCategoryId,
                    'slug' => Str::slug($subCategoryId) . '-' . uniqid()
                ]);
                $data['sub_category_id'] = $newSubCategory->id;
            }
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('datasheet')) {
            $data['datasheet'] = $request->file('datasheet')->store('datasheets', 'public');
        }

        $product = Product::create($data);

        if ($request->has('attributes_name') && $request->has('attributes_value')) {
            foreach ($request->attributes_name as $key => $name) {
                if (!empty($name) && !empty($request->attributes_value[$key])) {
                    $product->attributes()->create([
                        'name' => $name,
                        'value' => $request->attributes_value[$key]
                    ]);
                }
            }
        }

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $file) {
                $product->images()->create([
                    'image' => $file->store('products', 'public')
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        return view('admin.products.edit', compact('product', 'categories', 'subCategories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
            'brand' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'datasheet' => 'nullable|mimes:pdf|max:5120',
            'video_url' => 'nullable|url',
            'additional_images.*' => 'image|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        
        if ($request->name !== $product->name) {
            $data['slug'] = Str::slug($request->name) . '-' . uniqid();
        }

        $data['is_active'] = $request->has('is_active');

        // Handle dynamic category creation
        $categoryId = $request->category_id;
        if (!is_numeric($categoryId)) {
            $newCategory = Category::create([
                'name' => $categoryId,
                'slug' => Str::slug($categoryId) . '-' . uniqid()
            ]);
            $data['category_id'] = $newCategory->id;
        }

        // Handle dynamic sub category creation
        if ($request->filled('sub_category_id')) {
            $subCategoryId = $request->sub_category_id;
            if (!is_numeric($subCategoryId)) {
                $newSubCategory = SubCategory::create([
                    'category_id' => $data['category_id'],
                    'name' => $subCategoryId,
                    'slug' => Str::slug($subCategoryId) . '-' . uniqid()
                ]);
                $data['sub_category_id'] = $newSubCategory->id;
            }
        } else {
            $data['sub_category_id'] = null;
        }

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('datasheet')) {
            if ($product->datasheet) Storage::disk('public')->delete($product->datasheet);
            $data['datasheet'] = $request->file('datasheet')->store('datasheets', 'public');
        }

        $product->update($data);

        $product->attributes()->delete();
        if ($request->has('attributes_name') && $request->has('attributes_value')) {
            foreach ($request->attributes_name as $key => $name) {
                if (!empty($name) && !empty($request->attributes_value[$key])) {
                    $product->attributes()->create([
                        'name' => $name,
                        'value' => $request->attributes_value[$key]
                    ]);
                }
            }
        }

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $file) {
                $product->images()->create([
                    'image' => $file->store('products', 'public')
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        if ($product->datasheet) Storage::disk('public')->delete($product->datasheet);
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
