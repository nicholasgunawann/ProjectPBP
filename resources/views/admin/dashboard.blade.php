<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Dashboard Admin
    </h2>
  </x-slot>

  <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
      <h3 class="text-lg font-semibold mb-4">Selamat datang, {{ auth()->user()->name }} 👋</h3>
      <p class="text-gray-600 mb-6">Ini adalah ringkasan aktivitas toko kamu hari ini.</p>

      {{-- Statistik --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
          <h4 class="text-sm text-gray-600">Total Produk</h4>
          <p class="text-3xl font-bold text-green-600">{{ \App\Models\Product::count() }}</p>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
          <h4 class="text-sm text-gray-600">Pesanan Diproses</h4>
          <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Order::where('status', 'diproses')->count() }}</p>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
          <h4 class="text-sm text-gray-600">Pesanan Dikirim</h4>
          <p class="text-3xl font-bold text-yellow-600">{{ \App\Models\Order::where('status', 'dikirim')->count() }}</p>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
          <h4 class="text-sm text-gray-600">Total Pengguna</h4>
          <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
