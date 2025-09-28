<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Pesanan Saya</h2></x-slot>
  <div class="py-6"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    @forelse($orders as $o)
      <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-3">
        <div class="flex justify-between">
          <div>#{{ $o->id }} • {{ $o->created_at->format('d M Y H:i') }}</div>
          <div class="font-semibold">{{ strtoupper($o->status) }}</div>
        </div>
        <div class="text-sm text-gray-600">Alamat: {{ $o->address_text }}</div>
        <ul class="mt-2 text-sm">
          @foreach($o->items as $it)
            <li>{{ $it->product->name }} x {{ $it->qty }} — Rp {{ number_format($it->subtotal,0,',','.') }}</li>
          @endforeach
        </ul>
        <div class="mt-2 font-bold">Total: Rp {{ number_format($o->total,0,',','.') }}</div>
      </div>
    @empty
      <div class="bg-white shadow-sm sm:rounded-lg p-6">Belum ada pesanan.</div>
    @endforelse
    <div class="mt-4">{{ $orders->links() }}</div>
  </div></div>
</x-app-layout>
