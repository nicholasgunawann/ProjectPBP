{{-- resources/views/admin/products/create.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="page-title">Tambah Produk</h2>
  </x-slot>

  <div class="product-create-scope">
    <div class="wrap">
      <div class="card">
        <div class="card-bg"></div>
        <div class="card-body">


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
                action="{{ route('admin.products.store') }}"
                enctype="multipart/form-data"
                class="grid">
            @csrf

            <!-- LEFT -->
            <div class="col">
              <div class="form-group">
                <label>Nama Produk</label>
                <input name="name" type="text" placeholder="Contoh: Kaos Oversize" required>
              </div>

              <div class="grid-2">
                <div class="form-group">
                  <label>Harga (Rp)</label>
                  <input name="price" type="number" min="0" placeholder="50000" required>
                </div>
                <div class="form-group">
                  <label>Stok</label>
                  <input name="stock" type="number" min="0" placeholder="100" required>
                </div>
              </div>

              <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" required>
                  <option value="">Pilih Kategori</option>
                  @php($__categories = (isset($categories) ? $categories : \App\Models\Category::orderBy('name')->get()))
                  @foreach($__categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Status</label>
                <select name="is_active" required>
                  <option value="1" selected>Aktif</option>
                  <option value="0">Nonaktif</option>
                </select>
              </div>
            </div>

            <!-- RIGHT -->
            <div class="col">
              <label class="label">Gambar Produk</label>

              <div id="dropzone" class="dropzone">
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

              <div class="preview-wrap">
                <img id="preview" alt="Preview gambar produk" class="preview hidden">
                <div id="previewPlaceholder" class="preview ph">Belum ada gambar dipilih</div>
              </div>
            </div>

            <!-- ACTIONS -->
            <div class="actions">
              <a href="{{ url()->previous() }}" class="btn btn-ghost">Batal</a>
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <style>
    .product-create-scope { --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
                            --green-100:#d7f5da; --green-200:#bff0c2; --border:#e2e8f0;
                            --radius:14px; --shadow:0 10px 30px rgba(16,24,40,.08); }
    .page-title{font:600 20px/1.3 ui-sans-serif,system-ui,Segoe UI,Roboto,Arial;color:#1f2937;margin:0}
    .product-create-scope .wrap{padding:24px}
    .product-create-scope .card{position:relative;border-radius:20px;overflow:hidden;box-shadow:var(--shadow);border:1px solid var(--border);background:#fff}
    .product-create-scope .card-bg{position:absolute;inset:0;background:linear-gradient(135deg,var(--yellow-100),var(--green-100));opacity:.35}
    .product-create-scope .card-body{position:relative;padding:24px}
    .product-create-scope .section-head .title{margin:0 0 6px;font:700 22px/1.2 ui-sans-serif,system-ui}
    .product-create-scope .badge{display:inline-block;padding:6px 10px;border-radius:999px;font:600 13px/1;color:#78350f}
    .product-create-scope .badge-yellow{background:var(--yellow-200)}
    .product-create-scope .title-sub{color:#166534;font-weight:600;margin-left:6px}
    .product-create-scope .alert{border-radius:12px;padding:12px 14px;margin:14px 0;font-size:14px;background:#fee2e2;border:1px solid #fecaca;color:#991b1b}
    .product-create-scope .alert ul{margin:6px 0 0 18px}

    .product-create-scope .grid{display:grid;grid-template-columns:1fr;gap:20px}
    @media(min-width:980px){.product-create-scope .grid{grid-template-columns:1fr 1fr}}
    .product-create-scope .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}

    .product-create-scope .form-group{margin-bottom:18px}
    .product-create-scope .label, 
    .product-create-scope .form-group label{display:block;font-weight:600;color:#0f172a;font-size:14px;margin:0 0 6px}
    .product-create-scope .form-group input, 
    .product-create-scope .form-group select{
      width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:12px;background:#fff;
      font-size:14px;outline:none;transition:.15s border,.15s box-shadow;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
    }
    .product-create-scope .form-group select{
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23334155' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      padding-right: 36px;
    }
    .product-create-scope .form-group input:focus, 
    .product-create-scope .form-group select:focus{border-color:var(--yellow-300);box-shadow:0 0 0 4px rgba(247,233,107,.35)}

    .product-create-scope .check{display:inline-flex;align-items:center;gap:8px;margin-top:8px;cursor:pointer}
    .product-create-scope .check input{width:16px;height:16px}

    .product-create-scope .dropzone{
      position:relative;border:2px dashed #f2e8a0;background:rgba(255,249,204,.55);
      border-radius:16px;padding:14px;display:flex;align-items:center;gap:12px;transition:.15s background,.15s border-color;cursor:pointer;
    }
    .product-create-scope .dropzone:hover{background:rgba(255,249,204,.8);border-color:var(--yellow-300)}
    .product-create-scope .dz-icon{flex:0 0 56px;height:56px;border-radius:14px;background:linear-gradient(135deg,var(--yellow-200),var(--green-200));display:grid;place-items:center;color:#7a5d00}
    .product-create-scope .dz-text{font-size:14px;color:#1f2937}
    .product-create-scope .dz-sub{font-size:12px;color:#64748b;margin-top:2px}
    .product-create-scope .dz-input{position:absolute;inset:0;opacity:0;cursor:pointer}

    .product-create-scope .preview-wrap{margin-top:12px;border:1px solid #d1fae5;border-radius:16px;overflow:hidden;background:#fff}
    .product-create-scope .preview{width:100%;aspect-ratio:4/3;object-fit:cover;display:block}
    .product-create-scope .preview.ph{display:grid;place-items:center;width:100%;aspect-ratio:4/3;color:#64748b;font-size:13px}
    .product-create-scope .hidden{display:none !important}

    .product-create-scope .actions{display:flex;justify-content:flex-end;gap:10px;padding-top:6px}
    .product-create-scope .btn{border-radius:12px;padding:10px 16px;font-weight:700;border:1px solid transparent;background:#e5e7eb;color:#111827;cursor:pointer;transition:.15s transform,.15s background}
    .product-create-scope .btn:active{transform:translateY(1px)}
    .product-create-scope .btn-ghost{background:#fff;border-color:#e5e7eb}
    .product-create-scope .btn-ghost:hover{background:#f9fafb}
    .product-create-scope .btn-primary{
      background:linear-gradient(90deg,var(--yellow-300),var(--green-200));
      color:#052e16;border-color:#e5e7eb;box-shadow:0 6px 16px rgba(0,0,0,.05)
    }
    .product-create-scope .btn-primary:hover{background:linear-gradient(90deg,#ffe066,#bff0c2)}
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
