<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Manage
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      
      {{-- TAB NAVIGATION --}}
      <div class="tab-nav-orders">
        <a href="{{ route('admin.products.index') }}" class="tab-item-orders">
          <svg class="tab-icon-orders" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
          </svg>
          Produk
        </a>
        <a href="{{ route('admin.orders.index') }}" class="tab-item-orders active">
          <svg class="tab-icon-orders" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
          Pesanan
        </a>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
        @if ($orders->count())
          <table class="w-full text-left">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-3">Order</th>
                <th class="p-3">User</th>
                <th class="p-3">Status</th>
                <th class="p-3">Total</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orders as $o)
                <tr class="border-t">
                  <td class="p-3 font-semibold">{{ $o->order_number }}</td>
                  <td class="p-3">{{ $o->user->name ?? '-' }}</td>
                  <td class="p-3">
                    <span class="px-2 py-1 rounded text-white 
                      @if($o->status=='diproses') bg-yellow-500 
                      @elseif($o->status=='dikirim') bg-blue-500 
                      @elseif($o->status=='selesai') bg-green-600 
                      @elseif($o->status=='batal') bg-red-500 
                      @endif">
                      {{ strtoupper($o->status) }}
                    </span>
                  </td>
                  <td class="p-3">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                  <td class="p-3">{{ $o->created_at->format('d M Y H:i') }}</td>
                  <td class="p-3">
                    <a href="{{ route('admin.orders.show', $o) }}" 
                       class="px-3 py-1 bg-gray-800 text-white rounded text-sm hover:bg-gray-700">
                      Detail
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="p-6 text-center text-gray-600">
            Belum ada pesanan yang masuk.
          </div>
        @endif
      </div>

      <div class="mt-4">{{ $orders->links() }}</div>
    </div>
  </div>

  <style>
    .tab-nav-orders{
      display:flex;
      gap:8px;
      margin-bottom:20px;
      border-bottom:2px solid #e2e8f0;
      padding-bottom:0;
    }
    .tab-item-orders{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding:12px 20px;
      border-radius:12px 12px 0 0;
      font-weight:600;
      font-size:14px;
      color:#64748b;
      text-decoration:none;
      transition:0.2s all;
      border-bottom:3px solid transparent;
      margin-bottom:-2px;
    }
    .tab-item-orders:hover{
      color:#0f172a;
      background:#f9fafb;
    }
    .tab-item-orders.active{
      color:#713f12;
      background:linear-gradient(135deg,#fef3a8,#f7e96b);
      border-bottom-color:#f3db37;
    }
    .tab-icon-orders{
      width:18px;
      height:18px;
    }
  </style>
</x-app-layout>
