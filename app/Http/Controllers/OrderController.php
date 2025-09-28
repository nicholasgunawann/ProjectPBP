<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * POST /checkout
     * Buat pesanan dari keranjang.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $request->validate([
            'address_text' => ['required','string','min:5','max:255'],
        ]);

        $cart = Cart::with('items.product')->where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error','Keranjang kosong.');
        }

        DB::transaction(function() use ($cart, $userId, $request) {
            $order = Order::create([
                'user_id' => $userId,
                'total' => 0,
                'status' => 'diproses',
                'address_text' => $request->address_text,
            ]);

            $total = 0;
            foreach ($cart->items as $ci) {
                $price = $ci->product->price;
                $qty   = $ci->qty;
                $sub   = $price * $qty;

                // (opsional) check stok + kurangi stok
                if ($ci->product->stock < $qty) {
                    throw new \RuntimeException("Stok tidak cukup untuk {$ci->product->name}");
                }
                $ci->product->decrement('stock', $qty);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $ci->product_id,
                    'price'      => $price,
                    'qty'        => $qty,
                    'subtotal'   => $sub,
                ]);

                $total += $sub;
            }

            $order->update(['total' => $total]);

            // kosongkan keranjang
            $cart->items()->delete();
        });

        return redirect()->route('products.index')->with('success','Checkout berhasil! Pesanan dibuat.');
    }

    /**
     * (opsional) GET /orders-saya
     * Lihat pesanan milik user
     */
    public function myOrders()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }
}
