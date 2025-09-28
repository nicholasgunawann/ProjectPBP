<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderAdminController extends Controller
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
        $status = $request->query('status'); // diproses, dikirim, selesai, batal
        $orders = Order::with(['user','items.product'])
            ->when($status, fn($q)=>$q->where('status', $status))
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
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success','Status pesanan diubah.');
    }
}
