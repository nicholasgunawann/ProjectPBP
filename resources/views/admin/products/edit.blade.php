<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit Produk</h2></x-slot>
  <div class="py-6"><div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <form method="POST" action="{{ route('admin.products.update',$product) }}" class="bg-white shadow-sm sm:rounded-lg p-6 grid gap-3">
      @csrf @method('PUT')
      <input class="border rounded px-3 py-2" name="name" value="{{ $product->name }}" required>
      <input class="border rounded px-3 py-2" name="price" type="number" min="0" value="{{ $product->price }}" required>
      <input class="border rounded px-3 py-2" name="stock" type="number" min="0" value="{{ $product->stock }}" required>
      <select class="border rounded px-3 py-2" name="category_id" required>
        @foreach(\App\Models\Category::orderBy('name')->get() as $c)
          <option value="{{ $c->id }}" @selected($product->category_id==$c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
      <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}> Aktif</label>
      <button class="px-4 py-2 bg-gray-900 text-white rounded">Update</button>
    </form>
  </div></div>
</x-app-layout>
