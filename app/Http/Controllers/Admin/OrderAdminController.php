<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status'); // diproses, dikirim, selesai, batal
        $orders = Order::with(['user','items.product'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders','status'));
    }

    public function show(Order $order)
    {
        $order->load(['user','items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', Rule::in(['diproses','dikirim','selesai','batal'])],
        ], [
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status yang dipilih tidak valid.',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Cegah pembatalan order yang sudah selesai
        if ($oldStatus === 'selesai' && $newStatus === 'batal') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order yang sudah selesai tidak bisa dibatalkan.'
                ], 400);
            }
            return back()->with('error', 'Order yang sudah selesai tidak bisa dibatalkan.');
        }

        // Kembalikan stok jika order dibatalkan
        if ($newStatus === 'batal' && $oldStatus !== 'batal') {
            $order->load('items.product');
            foreach ($order->items as $item) {
                // Kembalikan stok produk
                $item->product->increment('stock', $item->qty);
            }
        }

        $order->update(['status' => $newStatus]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan diubah.'
            ]);
        }

        return back()->with('success','Status pesanan diubah.');
    }
}
