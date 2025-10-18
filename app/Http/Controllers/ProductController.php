<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /products
     * Fitur:
     * - List produk
     * - Search by name/kategori (?q=, ?category_id=)
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category_id');

        $products = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when($q, fn($qq) =>
                $qq->where('name', 'like', "%{$q}%")
            )
            ->when($categoryId, fn($qq) =>
                $qq->where('category_id', $categoryId)
            )
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'q', 'categoryId'));
    }
}
