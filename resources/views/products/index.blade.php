<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Produk
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4">
            
            {{-- FORM PENCARIAN --}}
            <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-wrap items-center gap-3">
                <div class="flex-1 min-w-[200px]">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ $q ?? '' }}" 
                        placeholder="Cari produk..." 
                        class="border border-gray-300 rounded-md px-3 py-2 w-full text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                </div>

                <div>
                    <select 
                        name="category_id" 
                        class="border border-gray-300 rounded-md px-3 py-[9px] text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach(($categories ?? []) as $c)
                            <option value="{{ $c->id }}" @selected(($categoryId ?? null)==$c->id)>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-[9px] rounded-md font-medium text-sm transition h-[42px]">
                        CARI
                    </button>
                </div>
            </form>

            {{-- GRID PRODUK --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse ($products as $p)
                    <div class="bg-white border border-gray-100 rounded-lg p-5 shadow-sm">
                        <div class="text-xs text-gray-500">{{ $p->category?->name }}</div>
                        <h2 class="font-semibold text-gray-900">{{ $p->name }}</h2>
                        <div class="mt-2 font-bold text-gray-800">
                            Rp {{ number_format($p->price,0,',','.') }}
                        </div>
                        <div class="text-sm text-gray-600">Stok: {{ $p->stock }}</div>

                        @auth
                            <form method="POST" action="{{ route('cart.items.store') }}" class="mt-3 flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <input 
                                    type="number" 
                                    name="qty" 
                                    value="1" 
                                    min="1" 
                                    class="border rounded-md px-2 py-1 w-16 text-sm focus:ring-indigo-400 focus:outline-none"
                                >
                                <button 
                                    class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-md font-medium text-sm transition">
                                    Tambah
                                </button>
                            </form>
                        @else
                            <div class="mt-3 text-sm text-gray-500">Login untuk belanja.</div>
                        @endauth
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada produk.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
