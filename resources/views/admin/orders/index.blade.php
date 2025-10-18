<x-app-layout>
  <x-slot name="header">
    <h2 class="page-title">Manage</h2>
  </x-slot>

  <div class="order-index-scope">
    <div class="wrap">
      {{-- TAB NAVIGATION (tema sama dengan create) --}}
      <div class="tab-nav">
        <a href="{{ route('admin.products.index') }}" class="tab-item">
          <svg class="tab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
          </svg>
          Produk
        </a>
        <a href="{{ route('admin.orders.index') }}" class="tab-item active">
          <svg class="tab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
          Pesanan
        </a>
        <a href="{{ route('admin.categories.index') }}" class="tab-item">
          <svg class="tab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
          </svg>
          Kategori
        </a>
      </div>

      {{-- STATUS FILTER TABS --}}
      <div class="status-tabs">
        <a href="{{ route('admin.orders.index') }}" 
           class="status-tab {{ request('status') == null ? 'active' : '' }}">
          Semua
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'diproses']) }}" 
           class="status-tab {{ request('status') == 'diproses' ? 'active' : '' }}">
          Diproses
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'dikirim']) }}" 
           class="status-tab {{ request('status') == 'dikirim' ? 'active' : '' }}">
          Dikirim
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'selesai']) }}" 
           class="status-tab {{ request('status') == 'selesai' ? 'active' : '' }}">
          Selesai
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'batal']) }}" 
           class="status-tab {{ request('status') == 'batal' ? 'active' : '' }}">
          Dibatalkan
        </a>
      </div>

      {{-- TABLE WRAPPER --}}
      <div class="card">
        @if ($orders->count())
          <div class="table-wrap">
            <table class="tbl">
              <thead>
                <tr>
                  <th>Order</th>
                  <th>User</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Tanggal</th>
                  <th class="t-right">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($orders as $o)
                  <tr>
                    <td class="mono fw">{{ $o->order_number }}</td>
                    <td>{{ $o->user->name ?? '-' }}</td>
                    <td>
                      <span class="badge
                        @if($o->status=='diproses') st-diproses
                        @elseif($o->status=='dikirim') st-dikirim
                        @elseif($o->status=='selesai') st-selesai
                        @elseif($o->status=='batal') st-batal
                        @else st-pending
                        @endif">
                        @if($o->status=='batal')
                          DIBATALKAN
                        @else
                          {{ strtoupper($o->status) }}
                        @endif
                      </span>
                    </td>
                    <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                    <td>{{ $o->created_at->format('d M Y H:i') }}</td>
                    <td class="t-right">
                      <a href="{{ route('admin.orders.show', $o) }}" class="btn btn-accent">Detail</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="empty">
            <div class="empty-card">
              <div class="emoji">📦</div>
              <div class="txt">
                @if(request('status') == 'diproses')
                  Belum ada pesanan dengan status diproses.
                @elseif(request('status') == 'dikirim')
                  Belum ada pesanan dengan status dikirim.
                @elseif(request('status') == 'selesai')
                  Belum ada pesanan dengan status selesai.
                @elseif(request('status') == 'batal')
                  Belum ada pesanan dengan status dibatalkan.
                @else
                  Belum ada pesanan.
                @endif
              </div>
            </div>
          </div>
        @endif
      </div>

      <div class="pagination">
        {{ $orders->links() }}
      </div>
    </div>
  </div>

  <style>
    /* theme tokens: match create/product */
    .order-index-scope{
      --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
      --green-100:#d7f5da; --green-200:#bff0c2; --green-300:#9ae2a0;
      --ink:#0f172a; --muted:#64748b; --border:#e2e8f0; --soft:#f9fafb;
      --shadow:0 10px 30px rgba(16,24,40,.08);
    }
    .page-title{font:600 20px/1.3 ui-sans-serif,system-ui,Segoe UI,Roboto,Arial;margin:0;color:#1f2937}
    .order-index-scope .wrap{padding:24px}

    /* Tabs */
    .tab-nav{display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid var(--border)}
    .tab-item{display:inline-flex;align-items:center;gap:6px;padding:12px 20px;border-radius:12px 12px 0 0;font-weight:600;font-size:14px;color:#64748b;text-decoration:none;transition:.2s;border-bottom:3px solid transparent;margin-bottom:-2px}
    .tab-item:hover{color:#0f172a;background:#f9fafb}
    .tab-item.active{color:#713f12;background:linear-gradient(135deg,#fef3a8,#f7e96b);border-bottom-color:var(--yellow-300)}
    .tab-icon{width:18px;height:18px}

    /* Status Filter Tabs */
    .status-tabs{
      display:flex;
      gap:8px;
      margin-bottom:20px;
      flex-wrap:wrap;
      border-bottom:2px solid var(--border);
      padding-bottom:10px;
    }
    .status-tab{
      display:inline-flex;
      align-items:center;
      padding:8px 14px;
      border-radius:10px;
      font-weight:700;
      font-size:13px;
      color:#64748b;
      background:#fff;
      border:2px solid var(--border);
      text-decoration:none;
      transition:0.2s all;
      white-space:nowrap;
    }
    .status-tab:hover{
      color:#0f172a;
      background:#f9fafb;
      border-color:#cbd5e1;
    }
    .status-tab.active{
      color:#713f12;
      background:linear-gradient(135deg,#fef3a8,#f7e96b);
      border-color:#f3db37;
    }

    /* Card + table */
    .card{border:1px solid var(--border);border-radius:16px;background:#fff;box-shadow:var(--shadow);overflow:hidden}
    .table-wrap{overflow:auto}
    .tbl{width:100%;border-collapse:separate;border-spacing:0}
    .tbl thead th{background:#f9fafb;text-align:left;font-size:12px;color:#6b7280;padding:12px;border-bottom:1px solid var(--border)}
    .tbl tbody td{padding:12px;border-bottom:1px solid var(--border);font-size:14px}
    .tbl th,.tbl td{vertical-align:middle}
    .t-right{text-align:right}
    .mono{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono",monospace}
    .fw{font-weight:600;color:#0f172a}

    /* Badge status: gradient ala create */
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:800;border:1px solid transparent}
    .st-pending{background:#fff7ed;border-color:#fed7aa;color:#7c2d12}
    .st-diproses{background:linear-gradient(135deg,var(--yellow-200),var(--yellow-100));border-color:#fde68a;color:#713f12}
    .st-dikirim{background:linear-gradient(135deg,var(--green-300),var(--green-200));border-color:#bbf7d0;color:#14532d}
    .st-selesai{background:linear-gradient(135deg,#e0f2fe,#dcfce7);border-color:#bae6fd;color:#0b3a2a}
    .st-batal{background:linear-gradient(135deg,#fee2e2,#fecaca);border-color:#fecaca;color:#7f1d1d}

    /* Buttons: gradient match */
    .btn{display:inline-flex;align-items:center;gap:6px;border-radius:12px;padding:10px 16px;font-weight:700;font-size:13px;border:1px solid transparent;cursor:pointer;text-decoration:none;transition:.2s;white-space:nowrap}
    .btn-accent{background:linear-gradient(135deg,var(--green-300),var(--green-200));color:#14532d;box-shadow:0 4px 12px rgba(154,226,160,.3)}
    .btn-accent:hover{background:linear-gradient(135deg,var(--green-200),var(--green-100));transform:translateY(-2px);box-shadow:0 6px 16px rgba(154,226,160,.4)}

    /* Empty + pagination */
    .empty{display:grid;place-items:center;padding:28px}
    .empty-card{border:1px solid var(--border);border-radius:14px;background:#fff;padding:18px 22px;text-align:center;box-shadow:var(--shadow)}
    .empty .emoji{font-size:22px}
    .empty .txt{margin-top:6px;color:#334155}
    .pagination{margin-top:14px}
  </style>
</x-app-layout>
