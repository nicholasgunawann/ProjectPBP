<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Produk
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4">
            
            {{-- FORM PENCARIAN --}}
            <form method="GET" action="{{ route('products.index') }}" class="search-filters" id="searchForm">
                <div class="filter-group">
                    <div class="input-with-icon">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input 
                            type="text" 
                            name="q" 
                            id="searchInput"
                            value="{{ $q ?? '' }}" 
                            placeholder="Cari produk..." 
                            class="search-input"
                        >
                    </div>
                    
                    <div class="input-with-icon">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <select name="category_id" id="categorySelect" class="search-input">
                            <option value="">Semua Kategori</option>
                            @foreach(($categories ?? []) as $c)
                                <option value="{{ $c->id }}" @selected(($categoryId ?? null)==$c->id)>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="filter-actions" style="display:none;">
                    <button type="submit" class="btn-search">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                </div>
            </form>

            {{-- GRID PRODUK --}}
            <div class="product-grid" id="productGrid">
                @forelse ($products as $p)
                    <div class="product-card">
                        {{-- Thumbnail --}}
                        <div class="thumb-wrap">
                            @if($p->image)
                                <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" class="thumb">
                            @else
                                <div class="thumb placeholder">No Image</div>
                            @endif
                            
                            @if($p->is_active)
                                <span class="badge badge-active">Aktif</span>
                            @else
                                <span class="badge badge-inactive">Nonaktif</span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="card-info">
                            <h2 class="product-title" title="{{ $p->name }}">{{ Str::limit($p->name, 48) }}</h2>
                            
                            <div class="product-meta">
                                <div>
                                    <span class="meta-label">Harga</span>
                                    <span class="meta-value">Rp {{ number_format($p->price,0,',','.') }}</span>
                                </div>
                                <div>
                                    <span class="meta-label">Stok</span>
                                    <span class="meta-value">{{ $p->stock }}</span>
                                </div>
                                <div>
                                    <span class="meta-label">Kategori</span>
                                    <span class="meta-value">{{ $p->category->name ?? '—' }}</span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            @auth
                                @if(auth()->user()->role !== 'admin')
                                    @if($p->is_active && $p->stock > 0)
                                        <form method="POST" action="{{ route('cart.items.store') }}" class="product-actions add-to-cart-form" data-product-id="{{ $p->id }}" data-max-stock="{{ $p->stock }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                                            <input 
                                                type="number" 
                                                name="qty" 
                                                value="1" 
                                                min="1" 
                                                class="qty-input"
                                            >
                                            <button type="submit" class="btn-add-cart">
                                                Tambah
                                            </button>
                                        </form>
                                    @else
                                        <div class="product-actions">
                                            <button disabled class="btn-disabled">
                                                @if(!$p->is_active)
                                                    Tidak Tersedia
                                                @else
                                                    Stok Habis
                                                @endif
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    <div class="product-actions">
                                        <a href="{{ route('admin.products.edit', $p->id) }}" class="btn-edit">
                                            Edit Produk
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="login-notice">Login untuk belanja.</div>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-card">
                            <div class="empty-icon">🛍️</div>
                            <div class="empty-text">Tidak ada produk yang ditemukan.</div>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <style>
        :root {
            --yellow-100: #fef3a8;
            --yellow-200: #f7e96b;
            --yellow-300: #f3db37;
            --green-100: #d7f5da;
            --green-200: #bff0c2;
            --border: #e2e8f0;
            --shadow: 0 10px 30px rgba(16,24,40,.08);
        }

        /* SEARCH FILTERS */
        .search-filters {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 24px;
            padding: 20px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }
        
        @media(min-width:768px) {
            .search-filters {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
        }
        
        @media(min-width:768px) {
            .filter-group {
                flex-direction: row;
            }
        }
        
        .filter-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .input-with-icon {
            position: relative;
            flex: 1;
            min-width: 200px;
        }
        
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #64748b;
            pointer-events: none;
            z-index: 1;
        }
        
        .search-input {
            width: 100%;
            padding: 11px 12px 11px 40px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            font-size: 14px;
            outline: none;
            transition: 0.2s all;
        }
        
        /* Select dropdown dengan panah */
        select.search-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
            padding-right: 40px;
        }
        
        .search-input:focus {
            border-color: var(--yellow-300);
            box-shadow: 0 0 0 3px rgba(247,233,107,.2);
        }
        
        .search-input:hover {
            border-color: #cbd5e1;
        }

        .btn-search {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--yellow-300), var(--yellow-200));
            color: #713f12;
            padding: 11px 18px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: 0.2s all;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(243,219,55,.3);
        }
        
        .btn-search:hover {
            background: linear-gradient(135deg, var(--yellow-200), var(--yellow-100));
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(243,219,55,.4);
        }
        
        .btn-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }


        /* GRID */
        .product-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        @media(min-width:640px) {
            .product-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media(min-width:1024px) {
            .product-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media(min-width:1280px) {
            .product-grid { grid-template-columns: repeat(4, 1fr); }
        }

        /* CARD */
        .product-card {
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(16,24,40,.12);
        }

        /* THUMBNAIL */
        .thumb-wrap {
            position: relative;
            background: linear-gradient(135deg, var(--yellow-100), var(--green-100));
        }
        .thumb {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            display: block;
        }
        .thumb.placeholder {
            display: grid;
            place-items: center;
            color: #64748b;
            background: #fffbe6;
            font-size: 13px;
        }

        /* BADGE */
        .badge {
            position: absolute;
            left: 10px;
            top: 10px;
            padding: 6px 8px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-active {
            background: #dcfce7;
            color: #065f46;
            border: 1px solid #bbf7d0;
        }
        .badge-inactive {
            background: #e5e7eb;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        /* CARD INFO */
        .card-info {
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .product-title {
            margin: 0;
            font: 700 16px/1.3 ui-sans-serif, system-ui;
            color: #0f172a;
        }
        .product-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .product-meta > div {
            display: flex;
            flex-direction: column;
        }
        .product-meta > div:last-child {
            grid-column: 1 / -1;
        }
        .meta-label {
            display: block;
            font-size: 12px;
            color: #6b7280;
        }
        .meta-value {
            display: block;
            font-size: 14px;
            color: #111827;
            font-weight: 600;
        }

        /* ACTIONS */
        .product-actions {
            display: flex;
            gap: 8px;
            margin-top: 6px;
            align-items: center;
        }
        .qty-input {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px;
            width: 60px;
            text-align: center;
            font-size: 14px;
            outline: none;
        }
        .qty-input:focus {
            border-color: var(--yellow-300);
            box-shadow: 0 0 0 3px rgba(243,219,55,.2);
        }
        .btn-add-cart {
            flex: 1;
            background: linear-gradient(135deg, #1f2937, #374151);
            color: #fff;
            padding: 10px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: 0.2s all;
        }
        .btn-add-cart:hover {
            background: linear-gradient(135deg, #111827, #1f2937);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,.2);
        }
        .btn-disabled {
            flex: 1;
            background: #e5e7eb;
            color: #9ca3af;
            padding: 10px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: not-allowed;
        }
        .btn-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            background: linear-gradient(135deg, var(--yellow-300), var(--yellow-200));
            color: #713f12;
            padding: 7px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            text-decoration: none;
            transition: 0.2s all;
            box-shadow: 0 2px 6px rgba(243,219,55,.25);
        }
        .btn-edit:hover {
            background: linear-gradient(135deg, var(--yellow-200), var(--yellow-100));
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(243,219,55,.35);
        }
        .login-notice {
            font-size: 13px;
            color: #6b7280;
            text-align: center;
            padding: 8px;
        }

        /* EMPTY STATE */
        .empty-state {
            grid-column: 1 / -1;
            display: grid;
            place-items: center;
            padding: 40px 0;
        }
        .empty-card {
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #fff;
            padding: 24px;
            text-align: center;
            box-shadow: var(--shadow);
        }
        .empty-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }
        .empty-text {
            color: #64748b;
            font-size: 14px;
        }
    </style>

    <script>
        // Live Search & Filter
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const categorySelect = document.getElementById('categorySelect');
        const productGrid = document.getElementById('productGrid');
        
        function loadProducts() {
            const q = searchInput.value;
            const category_id = categorySelect.value;
            const url = new URL(window.location.href);
            url.searchParams.set('q', q);
            url.searchParams.set('category_id', category_id);
            
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newGrid = doc.getElementById('productGrid');
                productGrid.innerHTML = newGrid.innerHTML;
                
                attachAddToCartListeners();
            });
        }
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(loadProducts, 300);
        });
        
        // filter kategori instan
        categorySelect.addEventListener('change', loadProducts);
        
        function attachAddToCartListeners() {
            const forms = document.querySelectorAll('.add-to-cart-form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const qtyInput = form.querySelector('input[name="qty"]');
                    const qtyValue = parseInt(qtyInput.value);
                    const maxStock = parseInt(form.dataset.maxStock);
                    const button = form.querySelector('.btn-add-cart');
                    
                    // Validasi stok
                    if (qtyValue < 1) {
                        showToast('Jumlah minimal adalah 1', 'error');
                        return;
                    }
                    
                    if (qtyValue > maxStock) {
                        showToast('Stok tidak mencukupi! Tersedia hanya ' + maxStock + ' pcs.', 'error');
                        return;
                    }
                    
                    const formData = new FormData(form);
                    button.disabled = true;
                    
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');
                            form.querySelector('input[name="qty"]').value = 1;
                        } else {
                            showToast(data.message || 'Terjadi kesalahan', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan', 'error');
                    })
                    .finally(() => {
                        button.disabled = false;
                    });
                });
            });
        }
        
        document.addEventListener('DOMContentLoaded', attachAddToCartListeners);
    </script>
</x-app-layout>
