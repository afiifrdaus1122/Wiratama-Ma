<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    public function index()
    {
        $categories = ArticleCategory::withCount('articles')->latest()->paginate(10);
        return view('admin.article-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:article_categories',
        ]);

        ArticleCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function update(Request $request, ArticleCategory $article_category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:article_categories,name,' . $article_category->id,
        ]);

        $article_category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy(ArticleCategory $article_category)
    {
        $article_category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
