<x-app-layout>
  <x-slot name="header">
    <h2 class="page-title">Dashboard</h2>
  </x-slot>

  <div class="dashboard-user-scope">
    <div class="wrap">
      {{-- WELCOME CARD --}}
      <div class="card welcome-card">
        <div class="card-bg"></div>
        <div class="card-body">
          <h3 class="title">Selamat datang, {{ auth()->user()->name }} 👋</h3>
          <p class="subtitle">Ringkasan aktivitas belanja Anda</p>
        </div>
      </div>

      {{-- STATS CARDS --}}
      <div class="stats-grid">
        <div class="stat-card stat-yellow">
          <div class="stat-icon">📦</div>
          <div class="stat-info">
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value">{{ \App\Models\Order::where('user_id', auth()->id())->count() }}</div>
          </div>
        </div>

        <div class="stat-card stat-blue">
          <div class="stat-icon">🚚</div>
          <div class="stat-info">
            <div class="stat-label">Sedang Diproses/Dikirim</div>
            <div class="stat-value">{{ \App\Models\Order::where('user_id', auth()->id())->whereIn('status', ['diproses', 'dikirim'])->count() }}</div>
          </div>
        </div>

        <div class="stat-card stat-green">
          <div class="stat-icon">✅</div>
          <div class="stat-info">
            <div class="stat-label">Pesanan Selesai</div>
            <div class="stat-value">{{ \App\Models\Order::where('user_id', auth()->id())->where('status', 'selesai')->count() }}</div>
          </div>
        </div>

        <div class="stat-card stat-mint">
          <div class="stat-icon">🛒</div>
          <div class="stat-info">
            <div class="stat-label">Item di Keranjang</div>
            @php
              $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
              $cartCount = $cart ? $cart->items()->count() : 0;
            @endphp
            <div class="stat-value">{{ $cartCount }}</div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <style>
    .dashboard-user-scope{
      --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
      --green-100:#d7f5da; --green-200:#bff0c2; --green-300:#9ae2a0;
      --blue-100:#dbeafe; --blue-200:#bfdbfe;
      --mint-100:#d4f1e8; --mint-200:#c8f0e0;
      --ink:#0f172a; --muted:#64748b; --border:#e2e8f0;
      --shadow:0 10px 30px rgba(16,24,40,.08);
    }
    .page-title{font:600 20px/1.3 ui-sans-serif,system-ui;margin:0;color:#1f2937}
    .wrap{padding:24px;max-width:1200px;margin:0 auto}

    /* Welcome Card */
    .welcome-card{position:relative;margin-bottom:24px}
    .card{border:1px solid var(--border);border-radius:16px;background:#fff;box-shadow:var(--shadow);overflow:hidden}
    .card-bg{position:absolute;inset:0;background:linear-gradient(135deg,var(--yellow-100),var(--green-100));opacity:.35;filter:blur(60px)}
    .card-body{position:relative;padding:20px}
    .title{margin:0 0 6px;font:700 18px/1.35 ui-sans-serif,system-ui;color:var(--ink)}
    .subtitle{margin:0 0 16px;color:#334155}

    /* Stats Grid */
    .stats-grid{display:grid;grid-template-columns:repeat(1,1fr);gap:16px;margin-bottom:32px}
    @media(min-width:640px){.stats-grid{grid-template-columns:repeat(2,1fr)}}
    @media(min-width:1024px){.stats-grid{grid-template-columns:repeat(4,1fr)}}

    .stat-card{
      display:flex;align-items:center;gap:16px;
      padding:20px;border-radius:14px;border:1px solid var(--border);
      box-shadow:0 6px 20px rgba(16,24,40,.08);transition:.2s;
    }
    .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(16,24,40,.12)}
    .stat-icon{font-size:32px}
    .stat-label{font-size:12px;color:#64748b;margin-bottom:4px}
    .stat-value{font-size:28px;font-weight:800;color:#0f172a}

    .stat-yellow{background:linear-gradient(135deg,#fef3a8,#f7e96b)}
    .stat-blue{background:linear-gradient(135deg,#dbeafe,#bfdbfe)}
    .stat-green{background:linear-gradient(135deg,#d7f5da,#bff0c2)}
    .stat-mint{background:linear-gradient(135deg,#d4f1e8,#c8f0e0)}

  </style>
</x-app-layout>
