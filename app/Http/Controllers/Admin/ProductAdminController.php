<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    public function __construct()
    {
        // pastikan role admin
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                abort(403, 'Admin only');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $q = $request->query('q');

        $products = Product::with('category')
            ->when($q, fn($qq)=>$qq->where('name','like',"%{$q}%"))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products','q'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required','string','max:150'],
            'price'       => ['required','integer','min:0'],
            'stock'       => ['required','integer','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $validated['is_active'] = (bool)($validated['is_active'] ?? true);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success','Produk dibuat.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => ['required','string','max:150'],
            'price'       => ['required','integer','min:0'],
            'stock'       => ['required','integer','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $validated['is_active'] = (bool)($validated['is_active'] ?? false);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success','Produk diupdate.');
    }

    public function destroy(Product $product)
    {
        // jika ingin cegah hapus saat ada order_items, bisa cek dulu
        $product->delete();
        return back()->with('success','Produk dihapus.');
    }

    public function toggleActive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return back()->with('success','Status aktif produk diubah.');
    }
}
