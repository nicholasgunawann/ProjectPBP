<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Admin • Produk</h2></x-slot>
  <div class="py-6"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-3"><a href="{{ route('admin.products.create') }}" class="px-3 py-2 bg-gray-900 text-white rounded">Tambah Produk</a></div>
    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
      <table class="w-full">
        <thead class="bg-gray-100 text-left"><tr>
          <th class="p-3">Nama</th><th class="p-3">Kategori</th><th class="p-3">Harga</th><th class="p-3">Stok</th><th class="p-3">Aktif</th><th class="p-3"></th>
        </tr></thead>
        <tbody>
          @foreach($products as $p)
            <tr class="border-t">
              <td class="p-3">{{ $p->name }}</td>
              <td class="p-3">{{ $p->category?->name }}</td>
              <td class="p-3">Rp {{ number_format($p->price,0,',','.') }}</td>
              <td class="p-3">{{ $p->stock }}</td>
              <td class="p-3">{{ $p->is_active ? 'Ya' : 'Tidak' }}</td>
              <td class="p-3 flex gap-2">
                <a class="px-3 py-1 bg-gray-800 text-white rounded text-sm" href="{{ route('admin.products.edit',$p) }}">Edit</a>
                <form method="POST" action="{{ route('admin.products.toggle',$p) }}">@csrf @method('PATCH')
                  <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Toggle</button>
                </form>
                <form method="POST" action="{{ route('admin.products.destroy',$p) }}">@csrf @method('DELETE')
                  <button class="px-3 py-1 bg-red-600 text-white rounded text-sm" onclick="return confirm('Hapus produk?')">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
  </div></div>
</x-app-layout>
