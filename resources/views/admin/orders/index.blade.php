<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Admin • Pesanan</h2></x-slot>
  <div class="py-6"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
      <table class="w-full">
        <thead class="bg-gray-100 text-left"><tr>
          <th class="p-3">Order</th><th class="p-3">User</th><th class="p-3">Status</th><th class="p-3">Total</th><th class="p-3"></th>
        </tr></thead>
        <tbody>
          @foreach($orders as $o)
            <tr class="border-t">
              <td class="p-3">#{{ $o->id }}</td>
              <td class="p-3">{{ $o->user->name }}</td>
              <td class="p-3">{{ $o->status }}</td>
              <td class="p-3">Rp {{ number_format($o->total,0,',','.') }}</td>
              <td class="p-3"><a class="px-3 py-1 bg-gray-800 text-white rounded text-sm" href="{{ route('admin.orders.show',$o) }}">Detail</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
  </div></div>
</x-app-layout>

