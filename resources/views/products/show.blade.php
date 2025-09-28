<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Detail Produk</h2></x-slot>
  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <div class="text-xs text-gray-500">{{ $product->category?->name }}</div>
        <h1 class="text-2xl font-semibold">{{ $product->name }}</h1>
        <div class="mt-2 font-bold">Rp {{ number_format($product->price,0,',','.') }}</div>
        <div class="text-sm text-gray-600">Stok: {{ $product->stock }}</div>
      </div>
    </div>
  </div>
</x-app-layout>
