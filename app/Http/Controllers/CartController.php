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
        // Wajib login untuk semua operasi keranjang
        $this->middleware('auth');
    }

    /**
     * GET /cart
     * Lihat isi keranjang.
     */
    public function show(Request $request)
    {
        $userId = Auth::id();
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
        $userId = Auth::id();
        $validated = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer','min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        if (!$product->is_active) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Produk tidak aktif.'], 422);
            }
            throw ValidationException::withMessages(['product_id' => 'Produk tidak aktif.']);
        }

        // Cek stok habis
        if ($product->stock <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Stok habis! Produk tidak dapat ditambahkan ke keranjang.'], 422);
            }
            return back()->with('error', 'Stok habis! Produk tidak dapat ditambahkan ke keranjang.');
        }

        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $newQty = ($item->exists ? $item->qty : 0) + $validated['qty'];
        if ($newQty < 1) $newQty = 1;

        // Validasi stok mencukupi
        if ($product->stock < $newQty) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi! Hanya tersedia ' . $product->stock . ' pcs.'], 422);
            }
            return back()->with('error', 'Stok tidak mencukupi! Hanya tersedia ' . $product->stock . ' pcs.');
        }

        $item->qty = $newQty;
        $item->save();

        if ($request->expectsJson()) {
            $cartCount = $cart->items()->sum('qty');
            return response()->json([
                'success' => true, 
                'message' => 'Produk ditambahkan ke keranjang.',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->route('cart.show')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    /**
     * PATCH /cart/items/{item}
     * Ubah jumlah item.
     */
    public function update(Request $request, CartItem $item)
    {
        $userId = Auth::id();
        $request->validate(['qty' => ['required','integer','min:1']]);

        // pastikan item milik cart user
        if ($item->cart->user_id !== $userId) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak boleh mengubah item orang lain.'], 403);
            }
            abort(403, 'Tidak boleh mengubah item orang lain.');
        }

        // validasi stok
        if ($item->product->stock < $request->qty) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi! Tersedia hanya ' . $item->product->stock . ' pcs.'], 422);
            }
            return back()->with('error', 'Stok tidak mencukupi! Tersedia hanya ' . $item->product->stock . ' pcs.');
        }

        $item->qty = (int) $request->qty;
        $item->save();

        if ($request->expectsJson()) {
            $cart = $item->cart->load('items.product');
            $grandTotal = 0;
            foreach ($cart->items as $ci) {
                $grandTotal += $ci->product->price * $ci->qty;
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Jumlah item diperbarui.',
                'subtotal' => $item->product->price * $item->qty,
                'grand_total' => $grandTotal,
                'cart_count' => $cart->items()->sum('qty')
            ]);
        }

        return back()->with('success', 'Jumlah item diperbarui.');
    }

    /**
     * DELETE /cart/items/{item}
     * Hapus item dari keranjang.
     */
    public function destroy(Request $request, CartItem $item)
    {
        $userId = Auth::id();
        if ($item->cart->user_id !== $userId) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak boleh menghapus item orang lain.'], 403);
            }
            abort(403, 'Tidak boleh menghapus item orang lain.');
        }

        $cart = $item->cart;
        $item->delete();

        if ($request->expectsJson()) {
            $cart->load('items.product');
            $grandTotal = 0;
            foreach ($cart->items as $ci) {
                $grandTotal += $ci->product->price * $ci->qty;
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Item dihapus.',
                'grand_total' => $grandTotal,
                'cart_count' => $cart->items()->sum('qty'),
                'is_empty' => $cart->items->isEmpty()
            ]);
        }

        return back()->with('success','Item dihapus.');
    }

    /**
     * DELETE /cart/clear
     * Kosongkan keranjang.
     */
    public function clear(Request $request)
    {
        $userId = Auth::id();
        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        $cart->items()->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Keranjang dikosongkan.',
                'cart_count' => 0,
                'is_empty' => true
            ]);
        }

        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
