{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="page-title">Dashboard Admin</h2>
  </x-slot>

  <div class="dashboard-scope">
    <div class="wrap">
      {{-- TAB NAVIGATION (tetap sesuai tema Product) --}}
      <div class="tab-nav">
        <a href="{{ route('admin.products.index') }}" class="tab-item">
          <svg class="tab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
          </svg>
          Produk
        </a>
        <a href="{{ route('admin.orders.index') }}" class="tab-item">
          <svg class="tab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
            </path>
          </svg>
          Pesanan
        </a>
        <div class="tab-spacer"></div>
        <span class="tab-item active">
          <svg class="tab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6">
            </path>
          </svg>
          Dashboard
        </span>
      </div>

      {{-- CARD UTAMA --}}
      <div class="card">
        <div class="card-bg"></div>
        <div class="card-body">
          <h3 class="title">Selamat datang, {{ auth()->user()->name }} 👋</h3>
          <p class="subtle">Ringkasan toko hari ini.</p>

          {{-- STAT CARDS (semua warna berbeda) --}}
          <div class="stats">
            <div class="stat stat-yellow">
              <div class="stat-k">Total Produk</div>
              <div class="stat-v">{{ \App\Models\Product::count() }}</div>
            </div>

            <div class="stat stat-lime">
              <div class="stat-k">Pesanan Dikirim</div>
              <div class="stat-v">{{ \App\Models\Order::where('status', 'dikirim')->count() }}</div>
            </div>

            <div class="stat stat-green">
              <div class="stat-k">Pesanan Diproses</div>
              <div class="stat-v">{{ \App\Models\Order::where('status', 'diproses')->count() }}</div>
            </div>

            <div class="stat stat-mint">
              <div class="stat-k">Pesanan Selesai</div>
              <div class="stat-v">{{ \App\Models\Order::where('status', 'selesai')->count() }}</div>
            </div>

            <div class="stat stat-red">
              <div class="stat-k">Pesanan Dibatalkan</div>
              <div class="stat-v">{{ \App\Models\Order::where('status', 'batal')->count() }}</div>
            </div>

            <div class="stat stat-ink">
              <div class="stat-k">Total Pengguna</div>
              <div class="stat-v">{{ \App\Models\User::count() }}</div>
            </div>
          </div>
        </div>
      </div>

      @isset($slot)
        <div class="card mt-4">
          <div class="card-body">
            {{ $slot }}
          </div>
        </div>
      @endisset
    </div>
  </div>

  <style>
    .dashboard-scope{
      --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
      --green-100:#d7f5da; --green-200:#bff0c2; --green-300:#9ae2a0;
      --red-100:#fee2e2; --red-200:#fecaca;
      --ink:#0f172a; --muted:#64748b; --border:#e2e8f0; --soft:#f9fafb;
      --shadow:0 10px 30px rgba(16,24,40,.08);
    }
    .page-title{font:600 20px/1.3 ui-sans-serif,system-ui,Segoe UI,Roboto,Arial;margin:0;color:#1f2937}
    .dashboard-scope .wrap{padding:24px}

    /* TAB NAV */
    .tab-nav{display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid var(--border)}
    .tab-item{display:inline-flex;align-items:center;gap:6px;padding:12px 20px;border-radius:12px 12px 0 0;font-weight:600;font-size:14px;color:#64748b;text-decoration:none;transition:.2s;border-bottom:3px solid transparent;margin-bottom:-2px}
    .tab-item:hover{color:#0f172a;background:#f9fafb}
    .tab-item.active{color:#713f12;background:linear-gradient(135deg,#fef3a8,#f7e96b);border-bottom-color:var(--yellow-300)}
    .tab-icon{width:18px;height:18px}
    .tab-spacer{flex:1}

    /* CARD */
    .card{position:relative;border:1px solid var(--border);border-radius:16px;background:#fff;box-shadow:var(--shadow);overflow:hidden}
    .card-bg{position:absolute;inset:0;background:linear-gradient(135deg,var(--yellow-100),var(--green-100));opacity:.35;filter:blur(60px)}
    .card-body{position:relative;padding:20px}
    .title{margin:0 0 6px;font:700 18px/1.35 ui-sans-serif,system-ui;color:var(--ink)}
    .subtle{margin:0 0 16px;color:#334155}

    /* STATS GRID */
    .stats{display:grid;grid-template-columns:repeat(1,minmax(0,1fr));gap:12px}
    @media(min-width:640px){.stats{grid-template-columns:repeat(2,1fr)}}
    @media(min-width:1024px){.stats{grid-template-columns:repeat(3,1fr)}}

    /* BASE STAT CARD */
    .stat{
      border:1px solid #e2e8f0;border-radius:14px;padding:16px;
      display:flex;flex-direction:column;gap:6px;box-shadow:0 6px 20px rgba(16,24,40,.08)
    }
    .stat-k{font-size:12px;color:#64748b}
    .stat-v{font-size:26px;font-weight:800;color:#0f172a;line-height:1}

    /* VARIAN WARNA (semua unik) */
    .stat-yellow{background:linear-gradient(135deg,#fef3a8,#f7e96b)}   /* Total Produk */
    .stat-lime{background:linear-gradient(135deg,#f7e96b,#d7f5da)}     /* Dikirim */
    .stat-green{background:linear-gradient(135deg,#bff0c2,#9ae2a0)}    /* Diproses */
    .stat-mint{background:linear-gradient(135deg,#d7f5da,#bff0c2)}     /* Selesai */
    .stat-red{background:linear-gradient(135deg,#fee2e2,#fecaca)}      /* Dibatalkan */
    .stat-ink{background:linear-gradient(135deg,#f9fafb,#e2e8f0)}      /* Total Pengguna */

    .mt-4{margin-top:16px}
  </style>
</x-app-layout>
