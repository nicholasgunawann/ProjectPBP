<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function __construct()
    {
        // Wajib login untuk operasi keranjang (lihat catatan di bawah kalau belum pasang auth)
        $this->middleware('auth')->except(['show']); // show bisa kamu buat public kalau mau
    }

    /**
     * GET /cart
     * Lihat isi keranjang.
     */
    public function show(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            // kalau belum ada auth, kamu bisa redirect ke login
            // return redirect()->route('login');
            // ATAU untuk demo:
            abort(403, 'Harus login untuk melihat keranjang.');
        }

        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        $cart->load('items.product');

        return view('cart.show', compact('cart'));
    }

    /**
     * POST /cart/items
     * Tambah item ke keranjang.
     */
    public function store(Request $request)
    {
        $userId = Auth::id() ?? abort(403, 'Harus login.');
        $validated = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer','min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        if (!$product->is_active) {
            throw ValidationException::withMessages(['product_id' => 'Produk tidak aktif.']);
        }

        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $newQty = ($item->exists ? $item->qty : 0) + $validated['qty'];
        if ($newQty < 1) $newQty = 1;

        // (opsional) validasi stok
        if ($product->stock < $newQty) {
            throw ValidationException::withMessages(['qty' => 'Stok tidak mencukupi.']);
        }

        $item->qty = $newQty;
        $item->save();

        return redirect()->route('cart.show')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    /**
     * PATCH /cart/items/{item}
     * Ubah jumlah item.
     */
    public function update(Request $request, CartItem $item)
    {
        $userId = Auth::id() ?? abort(403, 'Harus login.');
        $request->validate(['qty' => ['required','integer','min:1']]);

        // pastikan item milik cart user
        if ($item->cart->user_id !== $userId) {
            abort(403, 'Tidak boleh mengubah item orang lain.');
        }

        // validasi stok
        if ($item->product->stock < $request->qty) {
            throw ValidationException::withMessages(['qty' => 'Stok tidak mencukupi.']);
        }

        $item->qty = (int) $request->qty;
        $item->save();

        return back()->with('success', 'Jumlah item diperbarui.');
    }

    /**
     * DELETE /cart/items/{item}
     * Hapus item dari keranjang.
     */
    public function destroy(CartItem $item)
    {
        $userId = Auth::id() ?? abort(403, 'Harus login.');
        if ($item->cart->user_id !== $userId) {
            abort(403, 'Tidak boleh menghapus item orang lain.');
        }

        $item->delete();
        return back()->with('success','Item dihapus.');
    }

    /**
     * DELETE /cart/clear
     * Kosongkan keranjang.
     */
    public function clear()
    {
        $userId = Auth::id() ?? abort(403, 'Harus login.');
        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        $cart->items()->delete();

        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
