<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->category)))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('front.products.index', [
            'products' => $products,
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
            'activeCategory' => $request->category,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('front.products.show', [
            'product' => $product->load('category'),
        ]);
    }
}
