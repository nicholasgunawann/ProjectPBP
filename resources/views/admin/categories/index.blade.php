<x-app-layout>
  <x-slot name="header">
    <h2 class="page-title">Manage</h2>
  </x-slot>

  <div class="py-12 categories-scope">
    <div class="max-w-6xl mx-auto px-4">

      {{-- TAB NAVIGATION --}}
      <div class="tab-nav">
        <a href="{{ route('admin.products.index') }}" class="tab-item">
          <svg class="tab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
          </svg>
          Produk
        </a>
        <a href="{{ route('admin.orders.index') }}" class="tab-item">
          <svg class="tab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
          Pesanan
        </a>
        <a href="{{ route('admin.categories.index') }}" class="tab-item active">
          <svg class="tab-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
          </svg>
          Kategori
        </a>
      </div>

      {{-- FORM TAMBAH KATEGORI --}}
      <div class="glass-card mb-6">
        <div class="p-6">
          <h3 class="card-title">Tambah Kategori Baru</h3>
          <form method="POST" action="{{ route('admin.categories.store') }}" class="flex gap-3 form-inline">
            @csrf
            <input type="text" name="name" placeholder="Nama Kategori" required class="flex-1 input">
            <button type="submit" class="btn btn-green">Tambah</button>
          </form>
          @error('name')
          <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- DAFTAR KATEGORI --}}
      <div class="glass-card">
        <div class="p-6">
          <h3 class="card-title">Daftar Kategori</h3>
          <div class="space-y-3">
            @forelse($categories as $cat)
            <div class="flex items-center justify-between p-4 rounded-lg item-row">
              <div>
                <div class="item-title">{{ $cat->name }}</div>
                <div class="item-sub">{{ $cat->products_count }} produk</div>
              </div>
              <div class="flex gap-2">
                <button onclick="editCategory({{ $cat->id }}, '{{ $cat->name }}')" class="btn btn-warning">Edit</button>
                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Yakin hapus kategori {{ $cat->name }}?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" @if($cat->products_count > 0) disabled title="Kategori masih punya produk" @endif>Hapus</button>
                </form>
              </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-8">Belum ada kategori.</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- MODAL EDIT --}}
  <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="glass-modal">
      <h3 class="modal-title">Edit Kategori</h3>
      <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <input type="text" id="editName" name="name" placeholder="Nama Kategori" required class="modal-input">
        <div class="modal-actions">
          <button type="button" onclick="closeEditModal()" class="btn btn-ghost">Batal</button>
          <button type="submit" class="btn btn-green">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function editCategory(id, name) {
      document.getElementById('editForm').action = '/admin/categories/' + id;
      document.getElementById('editName').value = name;
      document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }
    document.getElementById('editModal').addEventListener('click', function(e) {
      if (e.target === this) closeEditModal();
    });
  </script>

  <style>
    .categories-scope {
      --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
      --green-100:#d7f5da; --green-200:#bff0c2; --green-300:#9ae2a0;
      --border:#e2e8f0; --shadow:0 10px 30px rgba(16,24,40,.08);
    }

    body, input, button {
      font-family: ui-sans-serif, system-ui, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .page-title {
      font-weight: 800;
      font-size: 22px;
      color: #111827;
      margin: 0;
    }

    /* Tabs */
    .tab-nav {
      display: flex;
      gap: 8px;
      margin-bottom: 24px;
      border-bottom: 2px solid #e5e7eb;
    }

    .tab-item {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 12px 20px;
      font-weight: 600;
      font-size: 14px;
      color: #6b7280;
      text-decoration: none;
      border-bottom: 3px solid transparent;
      transition: .2s;
    }

    .tab-item:hover {
      color: #0f172a;
      background: #f9fafb;
    }

    .tab-item.active {
      color: #713f12;
      background: linear-gradient(135deg, var(--yellow-100), var(--yellow-200));
      border-bottom-color: var(--yellow-300);
    }

    .tab-icon {
      width: 18px;
      height: 18px;
    }

    /* Glass card */
    .glass-card {
      background: rgba(255, 255, 255, 0.75);
      border: 1px solid rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(14px);
      border-radius: 16px;
      box-shadow: var(--shadow);
    }

    .card-title {
      font: 700 16px/1.3 ui-sans-serif, system-ui;
      color: #0f172a;
      margin: 0 0 12px;
    }

    /* Inputs */
    .input, .modal-input {
      background: rgba(255, 255, 255, 0.85);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 10px 12px;
      font-size: 14px;
      outline: none;
      transition: .2s;
    }

    .input:focus, .modal-input:focus {
      border-color: #22c55e;
      box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.25);
    }

    /* Item list */
    .item-row {
      background: rgba(255, 255, 255, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.5);
      backdrop-filter: blur(10px);
      transition: .2s;
    }

    .item-row:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(16,24,40,.08);
    }

    .item-title { font-weight: 600; color: #0f172a; }
    .item-sub { font-size: 13px; color: #6b7280; }

    /* Buttons */
    .btn {
      font-weight: 700;
      font-size: 14px;
      border: none;
      cursor: pointer;
      padding: 10px 16px;
      border-radius: 12px;
      transition: .2s;
    }

    .btn-green {
      background: linear-gradient(135deg, #86efac, #4ade80);
      color: #064e3b;
      box-shadow: 0 4px 12px rgba(74, 222, 128, 0.3);
    }

    .btn-warning {
      background: linear-gradient(135deg, #fde68a, #facc15);
      color: #78350f;
      border: 1px solid #fcd34d;
    }

    .btn-danger {
      background: linear-gradient(135deg, #fecaca, #fee2e2);
      color: #7f1d1d;
      border: 1px solid #fecaca;
    }

    .btn-ghost {
      background: rgba(255, 255, 255, 0.7);
      border: 1px solid #e2e8f0;
      color: #111827;
    }

    /* Modal */
    .glass-modal {
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(18px);
      border: 1px solid rgba(255, 255, 255, 0.5);
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(16,24,40,.15);
      padding: 24px;
      width: 380px;
      max-width: 90%;
      animation: popup .25s ease;
    }

    @keyframes popup {
      from { transform: scale(0.95); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .modal-title {
      text-align: center;
      font: 700 18px ui-sans-serif, system-ui;
      color: #0f172a;
      margin-bottom: 16px;
    }

    .modal-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }
  </style>
</x-app-layout>
