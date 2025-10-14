{{-- resources/views/admin/products/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="page-title">Daftar Produk</h2>
  </x-slot>

  <div class="product-index-scope">
    <div class="wrap">

      {{-- FILTER FORM --}}
      <form method="GET" action="{{ route('admin.products.index') }}" class="filters">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari produk...">
        <select name="category_id">
          <option value="">Semua Kategori</option>
          @php($__categories = (isset($categories) ? $categories : \App\Models\Category::orderBy('name')->get()))
          @foreach($__categories as $c)
            <option value="{{ $c->id }}" @selected(($categoryId ?? null)==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
        <button class="btn btn-primary" type="submit">Cari</button>
        <a href="{{ route('admin.products.create') }}" class="btn btn-accent">+ Tambah</a>
      </form>

      {{-- GRID PRODUK --}}
      @if(($products ?? collect())->count())
      <div class="grid">
        @foreach($products as $p)
          <div class="card">
            <div class="thumb-wrap">
              @if($p->image)
                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" class="thumb">
              @else
                <div class="thumb ph">No Image</div>
              @endif

              @if($p->is_active)
                <span class="badge badge-green">Aktif</span>
              @else
                <span class="badge badge-gray">Nonaktif</span>
              @endif
            </div>

            <div class="info">
              <h3 class="title" title="{{ $p->name }}">{{ Str::limit($p->name, 48) }}</h3>

              <div class="meta">
                <div><span class="k">Harga</span><span class="v">Rp {{ number_format($p->price,0,',','.') }}</span></div>
                <div><span class="k">Stok</span><span class="v">{{ $p->stock }}</span></div>
                <div><span class="k">Kategori</span><span class="v">{{ $p->category->name ?? '—' }}</span></div>
              </div>

              <div class="actions">
                <a class="btn btn-ghost" href="{{ route('products.show', $p->id) }}">Detail</a>
                <a class="btn btn-primary" href="{{ route('admin.products.edit', $p->id) }}">Edit</a>
                <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" onsubmit="return confirm('Hapus produk ini?')" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Hapus</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      @else
        <div class="empty">
          <div class="empty-card">
            <div class="emoji">🛍️</div>
            <div class="txt">Belum ada produk yang cocok.</div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-accent">Tambah Produk</a>
          </div>
        </div>
      @endif
    </div>
  </div>

  <style>
    .page-title{font:600 20px/1.3 ui-sans-serif,system-ui,Segoe UI,Roboto,Arial;margin:0;color:#1f2937}
    .product-index-scope{ --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
                          --green-100:#d7f5da; --green-200:#bff0c2; --green-300:#9ae2a0;
                          --ink:#0f172a; --muted:#64748b; --border:#e2e8f0; --soft:#f9fafb;
                          --danger:#dc2626; --gray:#6b7280; --shadow:0 10px 30px rgba(16,24,40,.08);}
    .product-index-scope .wrap{padding:24px}

    /* FILTERS */
    .product-index-scope .filters{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px}
    .product-index-scope .filters input,
    .product-index-scope .filters select{
      padding:10px 12px;border:1px solid var(--border);border-radius:12px;background:#fff;font-size:14px;outline:none;
      transition:.15s border,.15s box-shadow;
    }
    .product-index-scope .filters input:focus,
    .product-index-scope .filters select:focus{border-color:var(--yellow-300);box-shadow:0 0 0 4px rgba(247,233,107,.35)}

    .product-index-scope .btn{border-radius:12px;padding:10px 14px;font-weight:700;border:1px solid transparent;cursor:pointer;text-decoration:none;display:inline-block}
    .product-index-scope .btn-ghost{background:#fff;border-color:var(--border);color:#111827}
    .product-index-scope .btn-ghost:hover{background:#f3f4f6}
    .product-index-scope .btn-primary{background:linear-gradient(90deg,var(--yellow-300),var(--green-200));color:#052e16}
    .product-index-scope .btn-primary:hover{background:linear-gradient(90deg,#ffe066,#bff0c2)}
    .product-index-scope .btn-accent{background:linear-gradient(90deg,#fff3a0,#c8f3c8);color:#14532d;border:1px solid #e5e7eb}
    .product-index-scope .btn-accent:hover{background:linear-gradient(90deg,#ffe879,#bff0c2)}
    .product-index-scope .btn-danger{background:#fee2e2;color:#7f1d1d;border:1px solid #fecaca}
    .product-index-scope .btn-danger:hover{background:#fecaca}

    /* GRID */
    .product-index-scope .grid{display:grid;gap:16px;grid-template-columns:repeat(1,minmax(0,1fr))}
    @media(min-width:640px){.product-index-scope .grid{grid-template-columns:repeat(2,1fr)}}
    @media(min-width:1024px){.product-index-scope .grid{grid-template-columns:repeat(3,1fr)}}
    @media(min-width:1280px){.product-index-scope .grid{grid-template-columns:repeat(4,1fr)}}

    .product-index-scope .card{border:1px solid var(--border);border-radius:16px;overflow:hidden;background:#fff;box-shadow:var(--shadow);display:flex;flex-direction:column}
    .product-index-scope .thumb-wrap{position:relative;background:linear-gradient(135deg,var(--yellow-100),var(--green-100))}
    .product-index-scope .thumb{width:100%;aspect-ratio:4/3;object-fit:cover;display:block}
    .product-index-scope .thumb.ph{width:100%;aspect-ratio:4/3;display:grid;place-items:center;color:#64748b;background:#fffbe6;font-size:13px}

    .product-index-scope .badge{position:absolute;left:10px;top:10px;padding:6px 8px;border-radius:999px;font-size:12px;font-weight:700}
    .product-index-scope .badge-green{background:#dcfce7;color:#065f46;border:1px solid #bbf7d0}
    .product-index-scope .badge-gray{background:#e5e7eb;color:#374151;border:1px solid #d1d5db}

    .product-index-scope .info{padding:12px;display:flex;flex-direction:column;gap:10px}
    .product-index-scope .title{margin:0;font:700 16px/1.3 ui-sans-serif,system-ui;color:#0f172a}
    .product-index-scope .meta{display:grid;grid-template-columns:1fr 1fr;gap:8px}
    .product-index-scope .meta .k{display:block;font-size:12px;color:var(--gray)}
    .product-index-scope .meta .v{display:block;font-size:14px;color:#111827;font-weight:600}

    .product-index-scope .actions{display:flex;flex-wrap:wrap;gap:8px;margin-top:6px}
    


    /* EMPTY STATE */
    .product-index-scope .empty{display:grid;place-items:center;padding:40px 0}
    .product-index-scope .empty-card{border:1px solid var(--border);border-radius:16px;background:#fff;width:100%;max-width:520px;padding:24px;text-align:center;box-shadow:var(--shadow)}
    .product-index-scope .empty .emoji{font-size:28px}
    .product-index-scope .empty .txt{margin:8px 0 16px;color:#334155}
  </style>
</x-app-layout>
