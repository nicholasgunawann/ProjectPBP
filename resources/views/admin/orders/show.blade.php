<x-app-layout>
  <x-slot name="header">
    <h2 class="page-title">
      Detail Pesanan #{{ $order->id }}
    </h2>
  </x-slot>

  <div class="order-show-scope">
    <div class="wrap">
      <div class="card">
        <div class="card-bg"></div>
        <div class="card-body">

          <h3 class="title mb-2">Informasi Pemesan</h3>
          <div class="info-grid">
            <div><span class="k">Nama</span><span class="v">{{ $order->user->name ?? '-' }}</span></div>
            <div><span class="k">Email</span><span class="v">{{ $order->user->email ?? '-' }}</span></div>
            <div class="col-span-2"><span class="k">Alamat</span><span class="v">{{ $order->address_text }}</span></div>
            <div><span class="k">Tanggal Pesan</span><span class="v">{{ $order->created_at->format('d M Y H:i') }}</span></div>
            <div>
              <span class="k">Status</span>
              {{-- badge tema, tanpa ubah logika status --}}
              <span class="badge
                @if(strtolower($order->status)=='diproses') st-diproses
                @elseif(strtolower($order->status)=='dikirim') st-dikirim
                @elseif(strtolower($order->status)=='selesai') st-selesai
                @elseif(strtolower($order->status)=='batal') st-batal
                @else st-pending @endif">
                {{ strtoupper($order->status) }}
              </span>
            </div>
          </div>

          <hr class="divider">

          <h3 class="title mb-2">Daftar Produk</h3>
          <div class="table-wrap">
            <table class="tbl">
              <thead>
                <tr>
                  <th>Produk</th>
                  <th>Harga</th>
                  <th>Qty</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->items as $item)
                  <tr>
                    <td>{{ $item->product->name ?? 'Produk dihapus' }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="total-row">
            <span>Total</span>
            <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
          </div>

          <hr class="divider">

          <h3 class="title mb-2">Ubah Status Pesanan</h3>
          {{-- PAKAI ROUTE & METHOD AWAL: updateStatus + PATCH --}}
          <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
            @csrf
            @method('PATCH')
            <select name="status" class="sel" required>
              <option value="diproses" @selected($order->status == 'diproses')>Diproses</option>
              <option value="dikirim"  @selected($order->status == 'dikirim')>Dikirim</option>
              <option value="selesai"  @selected($order->status == 'selesai')>Selesai</option>
              <option value="batal"    @selected($order->status == 'batal')>Batal</option>
            </select>
            <button class="btn btn-primary">Simpan</button>
          </form>

          <div class="mt-6">
            <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">
              &larr; Kembali ke halaman admin
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>

  <style>
    .page-title{font:600 20px/1.3 ui-sans-serif,system-ui,Segoe UI,Roboto,Arial;margin:0;color:#1f2937}

    .order-show-scope{
      --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
      --green-100:#d7f5da; --green-200:#bff0c2; --green-300:#9ae2a0;
      --ink:#0f172a; --muted:#64748b; --border:#e2e8f0; --soft:#f9fafb;
      --shadow:0 10px 30px rgba(16,24,40,.08);
    }
    .order-show-scope .wrap{padding:24px}

    /* Card */
    .card{position:relative;border:1px solid var(--border);border-radius:16px;background:#fff;box-shadow:var(--shadow);overflow:hidden}
    .card-bg{position:absolute;inset:0;background:linear-gradient(135deg,var(--yellow-100),var(--green-100));opacity:.35;filter:blur(60px)}
    .card-body{position:relative;padding:20px}
    .title{margin:0;font:700 16px/1.3 ui-sans-serif,system-ui;color:#0f172a}
    .mb-2{margin-bottom:8px}
    .divider{margin:16px 0;border:0;border-top:1px solid var(--border)}

    /* Info grid */
    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
    .info-grid .k{display:block;font-size:12px;color:var(--muted)}
    .info-grid .v{display:block;font-size:14px;color:#111827;font-weight:600}
    .info-grid .col-span-2{grid-column:span 2}

    /* Table */
    .table-wrap{overflow:auto;border:1px solid var(--border);border-radius:14px;background:#fff}
    .tbl{width:100%;border-collapse:separate;border-spacing:0}
    .tbl thead th{background:#f9fafb;text-align:left;font-size:12px;color:#6b7280;padding:10px;border-bottom:1px solid var(--border)}
    .tbl tbody td{padding:12px;border-bottom:1px solid var(--border);font-size:14px}

    /* Total row */
    .total-row{display:flex;justify-content:space-between;align-items:center;margin-top:12px;font-size:15px}
    .total-row strong{font-size:18px;color:#0f172a}

    /* Select & Buttons – match create.blade */
    .sel{padding:11px 12px;border:1px solid var(--border);border-radius:12px;background:#fff;font-size:14px;outline:none;margin-right:10px}
    .sel:focus{border-color:var(--yellow-300);box-shadow:0 0 0 3px rgba(247,233,107,.2)}

    .btn{display:inline-flex;align-items:center;gap:6px;border-radius:12px;padding:10px 16px;font-weight:700;font-size:13px;border:1px solid transparent;cursor:pointer;text-decoration:none;transition:.2s}
    .btn-primary{background:linear-gradient(135deg,var(--yellow-300),var(--yellow-200));color:#713f12;box-shadow:0 4px 12px rgba(243,219,55,.3)}
    .btn-primary:hover{background:linear-gradient(135deg,var(--yellow-200),var(--yellow-100));transform:translateY(-2px);box-shadow:0 6px 16px rgba(243,219,55,.4)}
    .btn-ghost{background:#fff;border:1px solid var(--border);color:#111827}
    .btn-ghost:hover{background:#f3f4f6;transform:translateY(-1px)}

    /* Status badge (gradient) */
    .badge{display:inline-block;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:800;border:1px solid transparent}
    .st-diproses{background:linear-gradient(135deg,#fef3a8,#f7e96b);color:#713f12;border-color:#fde68a}
    .st-dikirim {background:linear-gradient(135deg,var(--green-300),var(--green-200));color:#14532d;border-color:#bbf7d0}
    .st-selesai {background:linear-gradient(135deg,#e0f2fe,#dcfce7);color:#064e3b;border-color:#bae6fd}
    .st-batal   {background:linear-gradient(135deg,#fee2e2,#fecaca);color:#7f1d1d;border-color:#fecaca}
    .st-pending {background:#fff7ed;color:#7c2d12;border-color:#fed7aa}
  </style>
</x-app-layout>
