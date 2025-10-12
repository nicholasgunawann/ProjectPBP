<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Admin • Detail Pesanan #{{ $order->id }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        <h3 class="font-semibold text-lg mb-3">Informasi Pemesan</h3>
        <p><strong>Nama:</strong> {{ $order->user->name ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ $order->address_text }}</p>
        <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
        <p><strong>Status:</strong>
          <span class="px-2 py-1 rounded text-white 
            @if($order->status=='diproses') bg-yellow-500 
            @elseif($order->status=='dikirim') bg-blue-500 
            @elseif($order->status=='selesai') bg-green-600 
            @elseif($order->status=='batal') bg-red-500 
            @endif">
            {{ strtoupper($order->status) }}
          </span>
        </p>

        <hr class="my-4">

        <h3 class="font-semibold text-lg mb-3">Daftar Produk</h3>
        <table class="w-full text-left border">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-3 border">Produk</th>
              <th class="p-3 border">Harga</th>
              <th class="p-3 border">Qty</th>
              <th class="p-3 border">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order->items as $item)
              <tr class="border-t">
                <td class="p-3 border">{{ $item->product->name ?? 'Produk dihapus' }}</td>
                <td class="p-3 border">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="p-3 border">{{ $item->qty }}</td>
                <td class="p-3 border">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="mt-4 text-right font-semibold">
          Total: Rp {{ number_format($order->total, 0, ',', '.') }}
        </div>

        <hr class="my-4">

        <h3 class="font-semibold text-lg mb-3">Ubah Status Pesanan</h3>
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
          @csrf
          @method('PATCH')
          <select name="status" class="border rounded p-2 mr-2">
            <option value="diproses" @selected($order->status == 'diproses')>Diproses</option>
            <option value="dikirim" @selected($order->status == 'dikirim')>Dikirim</option>
            <option value="selesai" @selected($order->status == 'selesai')>Selesai</option>
            <option value="batal" @selected($order->status == 'batal')>Batal</option>
          </select>
          <button class="bg-gray-800 text-white px-3 py-2 rounded hover:bg-gray-700">
            Simpan
          </button>
        </form>

        <div class="mt-6">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">
            &larr; Kembali ke halaman admin
        </a>
        </div>

      </div>
    </div>
  </div>
</x-app-layout>
