<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Admin • Pesanan Masuk
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
        @if ($orders->count())
          <table class="w-full text-left">
            <thead class="bg-gray-100">
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
              @foreach ($orders as $o)
                <tr class="border-t">
                  <td class="p-3 font-semibold">#{{ $o->id }}</td>
                  <td class="p-3">{{ $o->user->name ?? '-' }}</td>
                  <td class="p-3">
                    <span class="px-2 py-1 rounded text-white 
                      @if($o->status=='diproses') bg-yellow-500 
                      @elseif($o->status=='dikirim') bg-blue-500 
                      @elseif($o->status=='selesai') bg-green-600 
                      @elseif($o->status=='batal') bg-red-500 
                      @endif">
                      {{ strtoupper($o->status) }}
                    </span>
                  </td>
                  <td class="p-3">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                  <td class="p-3">{{ $o->created_at->format('d M Y H:i') }}</td>
                  <td class="p-3">
                    <a href="{{ route('admin.orders.show', $o) }}" 
                       class="px-3 py-1 bg-gray-800 text-white rounded text-sm hover:bg-gray-700">
                      Detail
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="p-6 text-center text-gray-600">
            Belum ada pesanan yang masuk.
          </div>
        @endif
      </div>

      <div class="mt-4">{{ $orders->links() }}</div>
    </div>
  </div>
</x-app-layout>
