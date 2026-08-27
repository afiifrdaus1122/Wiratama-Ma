<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductQuestion;

class ProductQuestionController extends Controller
{
    public function index()
    {
        $questions = ProductQuestion::with(['product', 'user'])->latest()->paginate(15);
        return view('admin.product_questions.index', compact('questions'));
    }

    public function update(Request $request, ProductQuestion $productQuestion)
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        $productQuestion->update([
            'answer' => $request->answer,
            'status' => 'answered'
        ]);

        return back()->with('success', 'Berhasil membalas pertanyaan.');
    }

    public function destroy(ProductQuestion $productQuestion)
    {
        $productQuestion->delete();
        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
