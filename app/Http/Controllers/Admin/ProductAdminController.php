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
        $perPage = $request->query('per_page', 5); // default tampil 5

        $products = \App\Models\Product::with('category')
            ->when($q, fn($qq) => $qq->where('name', 'like', "%{$q}%"))
            ->orderByDesc('id')
            ->get();

        $orders = \App\Models\Order::with('user')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('admin.products.index', compact('products', 'orders', 'q', 'perPage'));
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

    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // jika masih ada di keranjang pelanggan
        if ($product->cartItems()->exists()) {
            // jika admin sudah konfirmasi, hapus pakai cascade
            if ($request->has('confirm') && $request->confirm == 'yes') {
                $product->delete(); 
                return redirect()->route('admin.products.index')
                                ->with('success', 'Produk dan item terkait di keranjang berhasil dihapus.');
            }

            // jika admin belum konfirmasi, mengirimkan pesan ke view
            return back()->with('confirm_delete', [
                'id' => $product->id,
                'name' => $product->name,
                'message' => "Produk ini masih ada di keranjang pelanggan. Anda yakin akan menghapus produk ini?",
            ]);
        }

        // jika tidak ada di keranjang ataupun stok kosong
        if ($product->stock <= 0 || !$product->cartItems()->exists()) {
            $product->delete();
            return redirect()->route('admin.products.index')
                            ->with('success', 'Produk berhasil dihapus.');
        }

        // default fallback
        return back()->with('error', 'Terjadi kesalahan saat menghapus produk.');
    }

    public function toggleActive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return back()->with('success','Status aktif produk diubah.');
    }
}
