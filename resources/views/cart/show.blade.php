<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Keranjang</h2></x-slot>
  <div class="py-6"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    @if (!$cart || $cart->items->isEmpty())
      <div class="bg-white shadow-sm sm:rounded-lg p-6">Keranjang kosong.</div>
    @else
      <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-gray-100 text-left"><tr>
            <th class="p-3">Produk</th><th class="p-3">Harga</th><th class="p-3">Qty</th><th class="p-3">Subtotal</th><th class="p-3"></th>
          </tr></thead>
          <tbody>
            @php($grand=0)
            @foreach($cart->items as $item)
              @php($sub = $item->product->price * $item->qty) @php($grand += $sub)
              <tr class="border-t">
                <td class="p-3">{{ $item->product->name }}</td>
                <td class="p-3">Rp {{ number_format($item->product->price,0,',','.') }}</td>
                <td class="p-3">
                  <form method="POST" action="{{ route('cart.items.update',$item) }}" class="flex gap-2">
                    @csrf @method('PATCH')
                    <input type="number" name="qty" value="{{ $item->qty }}" min="1" class="border rounded px-2 py-1 w-20">
                    <button class="px-3 py-1 rounded bg-gray-800 text-white text-sm">Simpan</button>
                  </form>
                </td>
                <td class="p-3">Rp {{ number_format($sub,0,',','.') }}</td>
                <td class="p-3">
                  <form method="POST" action="{{ route('cart.items.destroy',$item) }}">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 rounded bg-red-600 text-white text-sm">Hapus</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot class="bg-gray-50"><tr>
            <td colspan="3" class="p-3 text-right font-semibold">Total</td>
            <td class="p-3 font-bold">Rp {{ number_format($grand,0,',','.') }}</td><td></td>
          </tr></tfoot>
        </table>
      </div>

      <div class="mt-4 flex gap-2">
        <form method="POST" action="{{ route('cart.clear') }}">@csrf @method('DELETE')
          <button class="px-4 py-2 rounded bg-gray-200">Kosongkan Keranjang</button>
        </form>
      </div>

      <form method="POST" action="{{ route('checkout.store') }}" class="mt-4 flex items-center gap-2">
        @csrf
        <input type="text" name="address_text" placeholder="Alamat Pengiriman" required class="border rounded px-3 py-2 w-full">
        <button class="bg-gray-900 text-white px-4 py-2 rounded">Checkout</button>
      </form>
    @endif
  </div></div>
</x-app-layout>
