<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductQuestionController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'question' => 'required|string|max:1000'
        ]);

        $product->questions()->create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'question' => $request->question,
        ]);

        return back()->with('success', 'Pertanyaan Anda berhasil dikirim dan sedang menunggu jawaban dari Admin.');
    }
}
