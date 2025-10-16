<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Pesanan Saya</h2></x-slot>
  
  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      
      {{-- STATUS FILTER TABS --}}
      <div class="order-tabs">
        <a href="{{ route('orders.mine') }}" 
           class="order-tab {{ request('status') == null ? 'active' : '' }}">
          Semua
        </a>
        <a href="{{ route('orders.mine', ['status' => 'diproses']) }}" 
           class="order-tab {{ request('status') == 'diproses' ? 'active' : '' }}">
          Diproses
        </a>
        <a href="{{ route('orders.mine', ['status' => 'dikirim']) }}" 
           class="order-tab {{ request('status') == 'dikirim' ? 'active' : '' }}">
          Dikirim
        </a>
        <a href="{{ route('orders.mine', ['status' => 'selesai']) }}" 
           class="order-tab {{ request('status') == 'selesai' ? 'active' : '' }}">
          Selesai
        </a>
        <a href="{{ route('orders.mine', ['status' => 'dibatalkan']) }}" 
           class="order-tab {{ request('status') == 'dibatalkan' ? 'active' : '' }}">
          Dibatalkan
        </a>
      </div>

      {{-- ORDERS LIST --}}
      @forelse($orders as $o)
        <div class="order-card">
          <div class="order-header">
            <div class="order-id">{{ $o->order_number }}</div>
            <span class="status-badge status-{{ $o->status }}">
              @if($o->status == 'diproses') ⏳ Diproses
              @elseif($o->status == 'dikirim') 🚚 Dikirim
              @elseif($o->status == 'selesai') ✅ Selesai
              @elseif($o->status == 'dibatalkan') ❌ Dibatalkan
              @else {{ $o->status }}
              @endif
            </span>
          </div>
          
          <div class="order-date">{{ $o->created_at->format('d M Y, H:i') }}</div>
          <div class="order-address">📍 {{ $o->address_text }}</div>
          
          <div class="order-items">
            @foreach($o->items as $it)
              <div class="order-item">
                <span class="item-name">{{ $it->product->name ?? 'Produk dihapus' }}</span>
                <span class="item-qty">x{{ $it->qty }}</span>
                <span class="item-price">Rp {{ number_format($it->subtotal,0,',','.') }}</span>
              </div>
            @endforeach
          </div>
          
          <div class="order-total">
            <span>Total Pembayaran</span>
            <span class="total-amount">Rp {{ number_format($o->total,0,',','.') }}</span>
          </div>
        </div>
      @empty
        <div class="empty-orders">
          <div class="empty-icon">📦</div>
          <div class="empty-text">Belum ada pesanan{{ request('status') ? ' dengan status '.request('status') : '' }}.</div>
        </div>
      @endforelse
      
      <div class="mt-6">{{ $orders->links() }}</div>
    </div>
  </div>

  <style>
    /* TABS */
    .order-tabs {
      display: flex;
      gap: 8px;
      margin-bottom: 20px;
      flex-wrap: wrap;
      border-bottom: 2px solid #e2e8f0;
      padding-bottom: 10px;
    }
    .order-tab {
      display: inline-flex;
      align-items: center;
      padding: 10px 16px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 14px;
      color: #64748b;
      background: #fff;
      border: 1px solid #e2e8f0;
      text-decoration: none;
      transition: 0.2s all;
      white-space: nowrap;
    }
    .order-tab:hover {
      color: #0f172a;
      background: #f9fafb;
      border-color: #cbd5e1;
    }
    .order-tab.active {
      color: #713f12;
      background: linear-gradient(135deg, #fef3a8, #f7e96b);
      border-color: #f3db37;
    }

    /* ORDER CARD */
    .order-card {
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 16px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: 0.2s all;
    }
    .order-card:hover {
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
      transform: translateY(-2px);
    }
    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    .order-id {
      font-weight: 700;
      font-size: 16px;
      color: #0f172a;
    }
    .status-badge {
      padding: 6px 12px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 700;
    }
    .status-diproses {
      background: #fef3c7;
      color: #92400e;
      border: 1px solid #fde68a;
    }
    .status-dikirim {
      background: #dbeafe;
      color: #1e40af;
      border: 1px solid #bfdbfe;
    }
    .status-selesai {
      background: #d1fae5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }
    .status-dibatalkan {
      background: #fee2e2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }
    .order-date {
      font-size: 13px;
      color: #6b7280;
      margin-bottom: 6px;
    }
    .order-address {
      font-size: 13px;
      color: #374151;
      margin-bottom: 12px;
      padding: 8px;
      background: #f9fafb;
      border-radius: 6px;
    }
    .order-items {
      border-top: 1px solid #e5e7eb;
      border-bottom: 1px solid #e5e7eb;
      padding: 12px 0;
      margin: 12px 0;
    }
    .order-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 6px 0;
      font-size: 14px;
    }
    .item-name {
      flex: 1;
      color: #374151;
    }
    .item-qty {
      color: #6b7280;
      margin: 0 12px;
    }
    .item-price {
      font-weight: 600;
      color: #0f172a;
    }
    .order-total {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 16px;
      font-weight: 700;
      color: #0f172a;
      margin-top: 8px;
    }
    .total-amount {
      color: #059669;
      font-size: 18px;
    }

    /* EMPTY STATE */
    .empty-orders {
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 40px;
      text-align: center;
    }
    .empty-icon {
      font-size: 48px;
      margin-bottom: 12px;
    }
    .empty-text {
      color: #6b7280;
      font-size: 14px;
    }
  </style>
</x-app-layout>
