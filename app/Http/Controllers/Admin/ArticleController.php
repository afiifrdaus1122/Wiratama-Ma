<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category', 'user')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = ArticleCategory::all();
        $products = Product::where('is_active', true)->latest()->get();
        return view('admin.articles.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        // Allow large article content (with embedded base64 images)
        ini_set('post_max_size', '256M');
        ini_set('upload_max_filesize', '256M');
        ini_set('memory_limit', '512M');

        $request->validate([
            'title'               => 'required|string|max:255',
            'article_category_id' => 'nullable',
            'content'             => 'required',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string',
            'meta_keywords'       => 'nullable|string|max:255',
            'is_published'        => 'boolean',
            'product_ids'         => 'nullable|array',
            'product_ids.*'       => 'integer|exists:products,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid();
        $data['user_id'] = auth()->id();

        // Handle dynamic category creation
        if (!empty($request->article_category_id) && !is_numeric($request->article_category_id)) {
            $newCat = ArticleCategory::create([
                'name' => $request->article_category_id,
                'slug' => Str::slug($request->article_category_id) . '-' . uniqid()
            ]);
            $data['article_category_id'] = $newCat->id;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        if ($request->is_published) {
            $data['published_at'] = now();
        }

        $article = Article::create($data);
        $article->products()->sync($request->input('product_ids', []));

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        $categories = ArticleCategory::all();
        $products = Product::where('is_active', true)->latest()->get();
        $article->load('products');
        return view('admin.articles.edit', compact('article', 'categories', 'products'));
    }

    public function update(Request $request, Article $article)
    {
        // Allow large article content (with embedded base64 images)
        ini_set('post_max_size', '256M');
        ini_set('upload_max_filesize', '256M');
        ini_set('memory_limit', '512M');

        $request->validate([
            'title'               => 'required|string|max:255',
            'article_category_id' => 'nullable',
            'content'             => 'required',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string',
            'meta_keywords'       => 'nullable|string|max:255',
            'is_published'        => 'boolean',
            'product_ids'         => 'nullable|array',
            'product_ids.*'       => 'integer|exists:products,id',
        ]);

        $data = $request->all();

        // Handle dynamic category creation
        if (!empty($request->article_category_id) && !is_numeric($request->article_category_id)) {
            $newCat = ArticleCategory::create([
                'name' => $request->article_category_id,
                'slug' => Str::slug($request->article_category_id) . '-' . uniqid()
            ]);
            $data['article_category_id'] = $newCat->id;
        }

        // Update slug only if title changes
        if ($request->title !== $article->title) {
            $data['slug'] = Str::slug($request->title) . '-' . uniqid();
        }

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        if ($request->is_published && !$article->published_at) {
            $data['published_at'] = now();
        } elseif (!$request->is_published) {
            $data['published_at'] = null;
        }

        $article->update($data);
        $article->products()->sync($request->input('product_ids', []));

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}
