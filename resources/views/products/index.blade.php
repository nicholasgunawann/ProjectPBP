<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Produk</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('products.index') }}" class="mb-4 flex gap-2">
                <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari produk..." class="border rounded px-3 py-2 w-full">
                <select name="category_id" class="border rounded px-3 py-2">
                    <option value="">Semua Kategori</option>
                    @foreach(($categories ?? []) as $c)
                        <option value="{{ $c->id }}" @selected(($categoryId ?? null)==$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
                <button class="bg-gray-900 text-white px-4 py-2 rounded">Cari</button>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($products as $p)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                        <div class="text-xs text-gray-500">{{ $p->category?->name }}</div>
                        <h2 class="font-semibold">{{ $p->name }}</h2>
                        <div class="mt-2 font-bold">Rp {{ number_format($p->price,0,',','.') }}</div>
                        <div class="text-sm text-gray-600">Stok: {{ $p->stock }}</div>

                        @auth
                        <form method="POST" action="{{ route('cart.items.store') }}" class="mt-3 flex gap-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                            <input type="number" name="qty" value="1" min="1" class="border rounded px-2 py-1 w-20">
                            <button class="bg-gray-900 text-white px-3 py-2 rounded">Tambah</button>
                        </form>
                        @else
                        <div class="mt-3 text-sm text-gray-500">Login untuk belanja.</div>
                        @endauth
                    </div>
                @empty
                    <p>Tidak ada produk.</p>
                @endforelse
            </div>

            <div class="mt-4">{{ $products->links() }}</div>
        </div>
    </div>
</x-app-layout>
