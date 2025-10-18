{{-- resources/views/admin/products/edit.blade.php --}}
<x-app-layout>
  {{-- Header tetap render di layout (navbar aman) --}}
  <x-slot name="header">
    <h2 class="page-title">Edit Produk</h2>
  </x-slot>

  {{-- ===== CONTENT (scoped) ===== --}}
  <div class="product-edit-scope">
    <div class="wrap">
      <div class="card">
        <div class="card-bg"></div>
        <div class="card-body">


          @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST"
                action="{{ route('admin.products.update', $product->id) }}"
                enctype="multipart/form-data"
                class="grid">
            @csrf
            @method('PUT')

            <!-- LEFT: data -->
            <div class="col">
              <div class="form-group">
                <label>Nama Produk</label>
                <input name="name" type="text" value="{{ old('name', $product->name) }}" required>
              </div>

              <div class="grid-2">
                <div class="form-group">
                  <label>Harga (Rp)</label>
                  <input name="price" type="number" min="0" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="form-group">
                  <label>Stok</label>
                  <input name="stock" type="number" min="0" value="{{ old('stock', $product->stock) }}" required>
                </div>
              </div>

              <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" required>
                  @php($__categories = (isset($categories) ? $categories : \App\Models\Category::orderBy('name')->get()))
                  @foreach($__categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Status</label>
                <select name="is_active" required>
                  <option value="1" @selected(old('is_active', $product->is_active) == 1)>Aktif</option>
                  <option value="0" @selected(old('is_active', $product->is_active) == 0)>Nonaktif</option>
                </select>
              </div>
            </div>

            <!-- RIGHT: gambar -->
            <div class="col">
              <label class="label">Gambar Produk</label>

              {{-- Gambar sekarang --}}
              <div class="current-wrap">
                @if($product->image)
                  <img src="{{ asset('storage/'.$product->image) }}" alt="Gambar saat ini" class="current">
                @else
                  <div class="current ph">Belum ada gambar</div>
                @endif
              </div>

              {{-- Dropzone ganti gambar --}}
              <div id="dropzone" class="dropzone" aria-label="Drop file di sini atau klik untuk pilih">
                <div class="dz-icon" aria-hidden="true">
                  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 15v4a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-4h2v4h10v-4h2ZM12 3l5 5h-3v6h-4V8H7l5-5Z"/>
                  </svg>
                </div>
                <div class="dz-text">
                  <strong>Drag & drop</strong> atau klik untuk pilih
                  <div class="dz-sub">PNG/JPG maks 2MB</div>
                </div>
                <input id="image" name="image" type="file" accept="image/*" class="dz-input">
              </div>

              {{-- Preview gambar baru --}}
              <div class="preview-wrap">
                <img id="preview" alt="Preview gambar baru" class="preview hidden">
                <div id="previewPlaceholder" class="preview ph">Belum ada gambar baru dipilih</div>
              </div>

              {{-- Hapus gambar lama --}}
              @if($product->image)
              <label class="check" style="margin-top:10px">
                <input type="checkbox" name="remove_image" value="1">
                <span>Hapus gambar saat ini</span>
              </label>
              @endif
            </div>

            <div class="actions">
              <a href="{{ url()->previous() }}" class="btn btn-ghost">Batal</a>
              <button class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- ===== /CONTENT ===== --}}

  <style>
    .product-edit-scope { --yellow-50:#fff9cc; --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
                          --green-50:#e9f9ec; --green-100:#d7f5da; --green-200:#bff0c2; --green-300:#9ae2a0;
                          --ink:#0f172a; --muted:#64748b; --border:#e2e8f0; --success:#16a34a;
                          --radius:14px; --ring:0 0 0 4px rgba(247,233,107,.35);
                          --shadow:0 10px 30px rgba(16,24,40,.08); }
    .page-title{font:600 20px/1.3 ui-sans-serif,system-ui,Segoe UI,Roboto,Arial;color:#1f2937;margin:0}
    .product-edit-scope .wrap{padding:24px}
    .product-edit-scope .card{position:relative;border-radius:calc(var(--radius) + 6px);overflow:hidden;box-shadow:var(--shadow);border:1px solid var(--border);background:#fff}
    .product-edit-scope .card-bg{position:absolute;inset:0;background:linear-gradient(135deg,var(--yellow-100),var(--green-100));opacity:.35}
    .product-edit-scope .card-body{position:relative;padding:24px}
    .product-edit-scope .section-head .title{margin:0 0 6px;font:700 22px/1.2 ui-sans-serif,system-ui}
    .product-edit-scope .badge{display:inline-block;padding:6px 10px;border-radius:999px;font:600 13px/1;color:#78350f}
    .product-edit-scope .badge-yellow{background:var(--yellow-200)}
    .product-edit-scope .title-sub{color:#166534;font-weight:600;margin-left:6px}
    .product-edit-scope .hint{margin:2px 0 0;color:var(--muted);font-size:12px}

    .product-edit-scope .alert{border-radius:12px;padding:12px 14px;margin:14px 0;font-size:14px}
    .product-edit-scope .alert-danger{background:#fee2e2;border:1px solid #fecaca;color:#991b1b}
    .product-edit-scope .alert-success{background:#dcfce7;border:1px solid #bbf7d0;color:var(--success)}

    .product-edit-scope .grid{display:grid;grid-template-columns:1fr;gap:20px}
    @media(min-width:980px){.product-edit-scope .grid{grid-template-columns:1fr 1fr}}
    .product-edit-scope .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}

    .product-edit-scope .form-group{margin-bottom:18px}
    .product-edit-scope .label, 
    .product-edit-scope .form-group label{display:block;font-weight:600;color:#0f172a;font-size:14px;margin:0 0 6px}
    .product-edit-scope .form-group input, 
    .product-edit-scope .form-group select{
      width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:12px;background:#fff;
      font-size:14px;outline:none;transition:.15s border,.15s box-shadow;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
    }
    .product-edit-scope .form-group select{
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23334155' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      padding-right: 36px;
    }
    .product-edit-scope .form-group input:focus, 
    .product-edit-scope .form-group select:focus{border-color:var(--yellow-300);box-shadow:var(--ring)}

    .product-edit-scope .check{display:inline-flex;align-items:center;gap:8px;margin-top:8px;user-select:none;cursor:pointer}
    .product-edit-scope .check input{width:16px;height:16px}

    .product-edit-scope .current-wrap{margin-bottom:12px;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;background:#fff}
    .product-edit-scope .current{width:100%;aspect-ratio:4/3;object-fit:cover;display:block}
    .product-edit-scope .current.ph{display:grid;place-items:center;width:100%;aspect-ratio:4/3;color:#64748b;font-size:13px}

    .product-edit-scope .dropzone{
      position:relative;border:2px dashed #f2e8a0;background:rgba(255,249,204,.55);
      border-radius:16px;padding:14px;display:flex;align-items:center;gap:12px;transition:.15s background,.15s border-color;cursor:pointer;
    }
    .product-edit-scope .dropzone:hover{background:rgba(255,249,204,.8);border-color:var(--yellow-300)}
    .product-edit-scope .dz-icon{flex:0 0 56px;height:56px;border-radius:14px;background:linear-gradient(135deg,var(--yellow-200),var(--green-200));display:grid;place-items:center;color:#7a5d00}
    .product-edit-scope .dz-text{font-size:14px;color:#1f2937}
    .product-edit-scope .dz-sub{font-size:12px;color:#64748b;margin-top:2px}
    .product-edit-scope .dz-input{position:absolute;inset:0;opacity:0;cursor:pointer}

    .product-edit-scope .preview-wrap{margin-top:12px;border:1px solid #d1fae5;border-radius:16px;overflow:hidden;background:#fff}
    .product-edit-scope .preview{width:100%;aspect-ratio:4/3;object-fit:cover;display:block}
    .product-edit-scope .preview.ph{display:grid;place-items:center;width:100%;aspect-ratio:4/3;color:#64748b;font-size:13px}
    .product-edit-scope .hidden{display:none !important}

    .product-edit-scope .actions{display:flex;justify-content:flex-end;gap:10px;padding-top:6px}
    .product-edit-scope .btn{border-radius:12px;padding:10px 16px;font-weight:700;border:1px solid transparent;background:#e5e7eb;color:#111827;cursor:pointer;transition:.15s transform,.15s background}
    .product-edit-scope .btn:active{transform:translateY(1px)}
    .product-edit-scope .btn-ghost{background:#fff;border-color:#e5e7eb}
    .product-edit-scope .btn-ghost:hover{background:#f9fafb}
    .product-edit-scope .btn-primary{
      background:linear-gradient(90deg,var(--yellow-300),var(--green-200));
      color:#052e16;border-color:#e5e7eb;box-shadow:0 6px 16px rgba(0,0,0,.05)
    }
    .product-edit-scope .btn-primary:hover{background:linear-gradient(90deg,#ffe066,#bff0c2)}
    .product-edit-scope .foot-hint{margin-top:10px;color:#6b7280;font-size:12px}
    .product-edit-scope code{background:#f3f4f6;border:1px solid #e5e7eb;border-radius:6px;padding:1px 6px}
  </style>

  <script>
    (function () {
      const input = document.getElementById('image');
      const preview = document.getElementById('preview');
      const placeholder = document.getElementById('previewPlaceholder');
      const dropzone = document.getElementById('dropzone');

      function setPreview(file) {
        if (!file || !file.type || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
          placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
      }

      input?.addEventListener('change', (e) => setPreview(e.target.files?.[0]));

      ['dragenter','dragover'].forEach(evt =>
        dropzone.addEventListener(evt, e => {
          e.preventDefault(); e.stopPropagation();
          dropzone.style.borderColor = '#f3db37';
          dropzone.style.background = 'rgba(255,249,204,.85)';
        })
      );
      ['dragleave','drop'].forEach(evt =>
        dropzone.addEventListener(evt, e => {
          e.preventDefault(); e.stopPropagation();
          dropzone.style.borderColor = '#f2e8a0';
          dropzone.style.background = 'rgba(255,249,204,.55)';
        })
      );
      dropzone.addEventListener('drop', e => {
        const file = e.dataTransfer.files?.[0];
        if (file) {
          const dt = new DataTransfer();
          dt.items.add(file);
          input.files = dt.files;
          setPreview(file);
        }
      });
    })();
  </script>
</x-app-layout>
