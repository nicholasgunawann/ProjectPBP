<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Dashboard Admin
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

      {{-- BAGIAN PRODUK --}}
      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Daftar Produk</h3>
          <a href="{{ route('admin.products.create') }}" 
             class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
             + Tambah Produk
          </a>
        </div>

      @if (session('confirm_delete'))
          @php $confirm = session('confirm_delete'); @endphp
          <div class="mb-4 bg-yellow-50 border border-yellow-300 text-yellow-800 p-4 rounded-md">
              <p class="mb-2 font-medium">{{ $confirm['message'] }}</p>
              <form method="POST" action="{{ route('admin.products.destroy', $confirm['id']) }}">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="confirm" value="yes">
                  <button type="submit"
                          class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                      Ya, Hapus
                  </button>
                  <a href="{{ route('admin.dashboard') }}" class="ml-2 text-gray-600 underline">
                      Batal
                  </a>
              </form>
          </div>
      @endif

        @if($products->count())
          <table class="w-full text-left">
            <thead style="background-color: #4ade80; color: #ffffff;">
              <tr>
                <th class="p-3">Nama</th>
                <th class="p-3">Kategori</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Stok</th>
                <th class="p-3">Aktif</th>
                <th class="p-3"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $p)
                <tr class="border-t">
                  <td class="p-3">{{ $p->name }}</td>
                  <td class="p-3">{{ $p->category->name ?? '-' }}</td>
                  <td class="p-3">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                  <td class="p-3">{{ $p->stock }}</td>
                  <td class="p-3">{{ $p->is_active ? 'Ya' : 'Tidak' }}</td>
                  <td class="p-3">
                    <div class="flex items-center gap-4">
                      <a href="{{ route('admin.products.edit', $p) }}" 
                        class="inline-block px-3 py-1 bg-gray-800 text-white rounded text-sm hover:bg-gray-700">
                        Edit
                      </a>

                      <form action="{{ route('admin.products.destroy', $p) }}" method="POST" 
                            onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                          Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <p class="text-gray-500">Belum ada produk.</p>
        @endif
      </div>

      {{-- BAGIAN PESANAN --}}
      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Daftar Pesanan</h3>

          {{-- Dropdown jumlah tampilan --}}
          <form method="GET" class="flex items-center space-x-2">
            <label for="per_page" class="text-sm text-gray-600">Tampilkan:</label>
            <select name="per_page" id="per_page" class="border-gray-300 rounded" onchange="this.form.submit()">
              @foreach([5,10,25,50,100] as $option)
                <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>
                  {{ $option }}
                </option>
              @endforeach
            </select>
          </form>
        </div>

        @if($orders->count())
          <table class="w-full text-left">
            <thead style="background-color: #4ade80; color: #ffffff;">
              <tr>
                <th class="p-3">Order</th>
                <th class="p-3">User</th>
                <th class="p-3">Status</th>
                <th class="p-3">Total</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $o)
                <tr class="border-t">
                  <td class="p-3 font-semibold">#{{ $o->id }}</td>
                  <td class="p-3">{{ $o->user->name ?? '-' }}</td>
                  <td class="p-3">{{ strtoupper($o->status) }}</td>
                  <td class="p-3">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                  <td class="p-3">{{ $o->created_at->format('d M Y H:i') }}</td>
                  <td class="p-3">
                    <a href="{{ route('admin.orders.show', $o) }}" class="px-3 py-1 bg-gray-800 text-white rounded text-sm hover:bg-gray-700">
                      Detail
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{-- Pagination links --}}
          <div class="mt-4">
            {{ $orders->links() }}
          </div>

        @else
          <p class="text-gray-500">Belum ada pesanan.</p>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
