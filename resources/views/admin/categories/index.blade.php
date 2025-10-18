<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Manage</h2>
    </x-slot>

    <div class="py-12">
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
            
            {{-- Form Tambah Kategori --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Tambah Kategori Baru</h3>
                    <form method="POST" action="{{ route('admin.categories.store') }}" class="flex gap-3">
                        @csrf
                        <input 
                            type="text" 
                            name="name" 
                            placeholder="Nama Kategori" 
                            required 
                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Tambah
                        </button>
                    </form>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Daftar Kategori --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Daftar Kategori</h3>
                    
                    <div class="space-y-3">
                        @forelse($categories as $cat)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $cat->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $cat->products_count }} produk</div>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2">
                                    {{-- Button Edit --}}
                                    <button 
                                        onclick="editCategory({{ $cat->id }}, '{{ $cat->name }}')" 
                                        class="px-4 py-2 bg-yellow-400 text-gray-800 rounded-md hover:bg-yellow-500 font-semibold text-sm"
                                    >
                                        Edit
                                    </button>
                                    
                                    {{-- Button Delete --}}
                                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Yakin hapus kategori {{ $cat->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold text-sm"
                                            @if($cat->products_count > 0) disabled title="Kategori masih punya produk" @endif
                                        >
                                            Hapus
                                        </button>
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

    {{-- Modal Edit --}}
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Edit Kategori</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input 
                    type="text" 
                    id="editName" 
                    name="name" 
                    placeholder="Nama Kategori" 
                    required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mb-4"
                >
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
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
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>

    <style>
        .page-title {
            font-weight: 800;
            font-size: 22px;
            color: #111827;
        }

        .tab-nav {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0;
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
            margin-bottom: -2px;
            transition: all 0.2s;
        }

        .tab-item:hover {
            color: #111827;
            background: #f9fafb;
        }

        .tab-item.active {
            color: #111827;
            border-bottom-color: #f59e0b;
        }

        .tab-icon {
            width: 18px;
            height: 18px;
        }
    </style>
</x-app-layout>
