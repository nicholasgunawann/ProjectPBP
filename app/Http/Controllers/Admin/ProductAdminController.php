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
            'image'       => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
        ]);

        $validated['is_active'] = (bool)($validated['is_active'] ?? true);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

    Product::create($validated);

    return redirect()->route('admin.products.index')->with('success','Produk berhasil ditambahkan');
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
            'image'       => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
        ]);

        $validated['is_active'] = (bool)($validated['is_active'] ?? false);

        // Handle checkbox hapus gambar
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = null;
        }
        // Handle upload gambar
        elseif ($request->hasFile('image')) {
            // Delete gambar lama (jika ada)
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success','Produk diupdate.');
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Cek apakah produk stok > 0 atau masih ada di keranjang
        $hasStock = $product->stock > 0;
        $inCart = $product->cartItems()->exists();

        // Jika stok > 0 ATAU ada di keranjang, minta konfirmasi
        if ($hasStock || $inCart) {
            // Jika admin sudah konfirmasi, hapus
            if ($request->has('confirm') && $request->confirm == 'yes') {
                $product->delete(); 
                return redirect()->route('admin.products.index')
                                ->with('success', 'Produk berhasil dihapus.');
            }

            // Jika belum konfirmasi, minta konfirmasi
            $message = '';
            if ($hasStock && $inCart) {
                $message = "Produk ini masih memiliki stok ({$product->stock}) dan ada di keranjang pelanggan. Anda yakin akan menghapus?";
            } elseif ($hasStock) {
                $message = "Produk ini masih memiliki stok ({$product->stock}). Anda yakin akan menghapus?";
            } else {
                $message = "Produk ini masih ada di keranjang pelanggan. Anda yakin akan menghapus?";
            }

            return back()->with('confirm_delete', [
                'id' => $product->id,
                'name' => $product->name,
                'message' => $message,
            ]);
        }

        // Jika stok = 0 dan tidak ada di keranjang, langsung hapus
        $product->delete();
        return redirect()->route('admin.products.index')
                        ->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleActive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return back()->with('success','Status aktif produk diubah.');
    }
}
