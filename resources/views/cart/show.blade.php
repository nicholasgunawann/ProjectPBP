<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">Keranjang</h2>
  </x-slot>

  {{-- Tambahkan style background hijau mint + min-height agar footer tidak naik --}}
  <div class="py-6" style="background-color: #f0fdf4; min-height: calc(100vh - 68px);"> 
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      @if (!$cart || $cart->items->isEmpty())
        
        {{-- Gunakan style .empty-card dari index.blade.php --}}
        <div class="empty-state" style="padding-top: 20px;">
            <div class="empty-card">
                <div class="empty-icon">🛒</div>
                <div class="empty-text">Keranjang kamu masih kosong.</div>
                <a href="{{ route('products.index') }}" class="btn-primary" style="margin-top: 16px; text-decoration: none;">
                    Mulai Belanja
                </a>
            </div>
        </div>

      @else
      
        {{-- Ganti style card default dengan .cart-card baru --}}
        <div class="cart-card">
          
          <div class="overflow-x-auto">
            <table class="cart-table">
              <thead class="text-left">
                <tr>
                  <th class="p-3">Produk</th>
                  <th class="p-3">Harga</th>
                  <th class="p-3">Qty</th>
                  <th class="p-3">Subtotal</th>
                  <th class="p-3"></th>
                </tr>
              </thead>
              <tbody>
                @php($grand=0)
                @foreach($cart->items as $item)
                  @php($sub = $item->product->price * $item->qty) @php($grand += $sub)
                  <tr class="border-t cart-row" data-item-id="{{ $item->id }}">
                    <td class="p-3 font-semibold">{{ $item->product->name }}</td>
                    <td class="p-3">Rp {{ number_format($item->product->price,0,',','.') }}</td>
                    <td class="p-3">
                      
                      <form method="POST" action="{{ route('cart.items.update',$item) }}" class="flex gap-2 update-qty-form" data-item-id="{{ $item->id }}" data-max-stock="{{ $item->product->stock }}">
                        @csrf @method('PATCH')
                        
                        {{-- Gunakan style .form-input --}}
                        <input 
                            type="number" 
                            name="qty" 
                            value="{{ $item->qty }}" 
                            min="1" 
                            class="form-input qty-input-field" 
                            style="width: 75px; text-align: center; padding: 7px 10px;"
                            data-item-id="{{ $item->id }}"
                        >
                        
                        {{-- Gunakan style .btn-edit dari index.blade.php --}}
                        <button type="submit" class="btn-edit" style="font-size: 14px;">Simpan</button>
                      
                      </form>
                    </td>
                    <td class="p-3 font-semibold subtotal-cell">Rp {{ number_format($sub,0,',','.') }}</td>
                    <td class="p-3 text-right">
                      
                      <form method="POST" action="{{ route('cart.items.destroy',$item) }}" class="delete-item-form" data-item-id="{{ $item->id }}">
                        @csrf @method('DELETE')
                        
                        {{-- Gunakan style .btn-danger-sm baru --}}
                        <button type="submit" class="btn-danger-sm">Hapus</button>
                      
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot class="border-t-2 border-gray-200">
                <tr>
                  <td colspan="3" class="p-3 text-right font-semibold text-gray-700">Total</td>
                  <td class="p-3 font-bold text-lg text-gray-900 grand-total-cell">Rp {{ number_format($grand,0,',','.') }}</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>

          {{-- Wrapper untuk tombol bawah --}}
          <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
            
            {{-- Tombol Kosongkan (kiri) --}}
            <form method="POST" action="{{ route('cart.clear') }}" id="clear-cart-form">
              @csrf @method('DELETE')
              
              {{-- Gunakan style .btn-danger baru --}}
              <button type="submit" class="btn-danger" id="clear-cart-btn">Kosongkan Keranjang</button>
            
            </form>

            {{-- Form Checkout (kanan) --}}
            <form method="POST" action="{{ route('checkout.store') }}" class="w-full md:w-auto flex flex-col sm:flex-row items-center gap-3">
              @csrf
              <input 
                type="text" 
                name="address_text" 
                placeholder="Alamat Pengiriman" 
                required 
                class="form-input"
                style="min-width: 300px;"
              >
              
              {{-- Gunakan style .btn-primary baru --}}
              <button type="submit" class="btn-primary w-full sm:w-auto">Checkout</button>
            
            </form>
          </div>

        </div> 
      @endif
    </div>
  </div>


  {{-- ====================================================================== --}}
  {{-- SEMUA STYLE DARI index.blade.php + STYLE BARU UNTUK HALAMAN KERANJANG --}}
  {{-- ====================================================================== --}}
  <style>
      :root {
          --yellow-100: #fef3a8;
          --yellow-200: #f7e96b;
          --yellow-300: #f3db37;
          --green-100: #d7f5da;
          --green-200: #bff0c2;
          --border: #e2e8f0;
          --shadow: 0 10px 30px rgba(16,24,40,.08);
      }

      /* SEARCH FILTERS (Dipakai sebagai referensi .cart-card) */
      .search-filters {
          display: flex;
          flex-direction: column;
          gap: 12px;
          margin-bottom: 24px;
          padding: 20px;
          background: #fff;
          border: 1px solid var(--border);
          border-radius: 16px;
          box-shadow: var(--shadow);
      }
      
      @media(min-width:768px) {
          .search-filters {
              flex-direction: row;
              justify-content: space-between;
              align-items: center;
          }
      }
      
      /* ... (Class-class lain dari index.blade.php tidak dihapus) ... */
      
      .input-with-icon {
          position: relative;
          flex: 1;
          min-width: 200px;
      }
      
      .input-icon {
          position: absolute;
          left: 12px;
          top: 50%;
          transform: translateY(-50%);
          width: 18px;
          height: 18px;
          color: #64748b;
          pointer-events: none;
          z-index: 1;
      }
      
      .search-input {
          width: 100%;
          padding: 11px 12px 11px 40px;
          border: 1px solid var(--border);
          border-radius: 12px;
          background: #fff;
          font-size: 14px;
          outline: none;
          transition: 0.2s all;
      }
      
      .search-input:focus {
          border-color: var(--yellow-300);
          box-shadow: 0 0 0 3px rgba(247,233,107,.2);
      }
      
      .search-input:hover {
          border-color: #cbd5e1;
      }

      .btn-search {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          background: linear-gradient(135deg, var(--yellow-300), var(--yellow-200));
          color: #713f12;
          padding: 11px 18px;
          border-radius: 12px;
          font-weight: 600;
          font-size: 14px;
          border: none;
          cursor: pointer;
          transition: 0.2s all;
          white-space: nowrap;
          box-shadow: 0 4px 12px rgba(243,219,55,.3);
      }
      
      .btn-search:hover {
          background: linear-gradient(135deg, var(--yellow-200), var(--yellow-100));
          transform: translateY(-2px);
          box-shadow: 0 6px 16px rgba(243,219,55,.4);
      }
      
      .btn-icon {
          width: 18px;
          height: 18px;
          flex-shrink: 0;
      }


      /* GRID (Tidak terpakai di sini, tapi biarkan saja) */
      .product-grid {
          display: grid;
          gap: 16px;
          grid-template-columns: repeat(1, minmax(0, 1fr));
      }
      @media(min-width:640px) {
          .product-grid { grid-template-columns: repeat(2, 1fr); }
      }
      @media(min-width:1024px) {
          .product-grid { grid-template-columns: repeat(3, 1fr); }
      }
      @media(min-width:1280px) {
          .product-grid { grid-template-columns: repeat(4, 1fr); }
      }

      /* CARD (Dipakai sebagai referensi .cart-card) */
      .product-card {
          border: 1px solid var(--border);
          border-radius: 16px;
          overflow: hidden;
          background: #fff;
          box-shadow: var(--shadow);
          display: flex;
          flex-direction: column;
          transition: transform 0.2s, box-shadow 0.2s;
      }
      .product-card:hover {
          transform: translateY(-4px);
          box-shadow: 0 15px 40px rgba(16,24,40,.12);
      }
      
      /* ... (Class-class lain dari index.blade.php tidak dihapus) ... */
      
      .btn-edit {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 4px;
          background: linear-gradient(135deg, var(--yellow-300), var(--yellow-200));
          color: #713f12;
          padding: 7px 10px;
          border-radius: 8px;
          font-weight: 600;
          font-size: 12px;
          text-decoration: none;
          transition: 0.2s all;
          box-shadow: 0 2px 6px rgba(243,219,55,.25);
          border: none;
          cursor: pointer;
      }
      .btn-edit:hover {
          background: linear-gradient(135deg, var(--yellow-200), var(--yellow-100));
          transform: translateY(-1px);
          box-shadow: 0 3px 10px rgba(243,219,55,.35);
      }

      /* EMPTY STATE */
      .empty-state {
          grid-column: 1 / -1;
          display: grid;
          place-items: center;
          padding: 40px 0;
      }
      .empty-card {
          border: 1px solid var(--border);
          border-radius: 16px;
          background: #fff;
          padding: 24px 32px;
          text-align: center;
          box-shadow: var(--shadow);
      }
      .empty-icon {
          font-size: 48px;
          margin-bottom: 12px;
      }
      .empty-text {
          color: #64748b;
          font-size: 14px;
      }

      /* ================================== */
      /* == CLASS BARU UNTUK CART.BLADE.PHP == */
      /* ================================== */

      /* Card utama untuk keranjang */
      .cart-card {
          border: 1px solid var(--border);
          border-radius: 16px;
          background: #fff;
          box-shadow: var(--shadow);
          padding: 20px;
      }
      @media(min-width: 768px) {
          .cart-card { padding: 24px; }
      }

      /* Input form (Alamat & Qty) */
      .form-input {
          width: 100%;
          padding: 11px 14px;
          border: 1px solid var(--border);
          border-radius: 12px;
          background: #fff;
          font-size: 14px;
          outline: none;
          transition: 0.2s all;
      }
      .form-input:focus {
          border-color: var(--yellow-300);
          box-shadow: 0 0 0 3px rgba(247,233,107,.2);
      }
      .form-input:hover {
          border-color: #cbd5e1;
      }

      /* Tombol Primary (Checkout) - Hijau */
      .btn-primary {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 6px;
          background: linear-gradient(135deg, var(--green-200), var(--green-100));
          color: #14532d; /* dark green text */
          padding: 11px 18px;
          border-radius: 12px;
          font-weight: 600;
          font-size: 14px;
          border: none;
          cursor: pointer;
          transition: 0.2s all;
          white-space: nowrap;
          box-shadow: 0 4px 12px rgba(191,240,194,.4);
          text-decoration: none;
      }
      .btn-primary:hover {
          background: linear-gradient(135deg, var(--green-100), #e0f8e2);
          transform: translateY(-2px);
          box-shadow: 0 6px 16px rgba(191,240,194,.5);
      }

      /* Tombol Danger (Kosongkan) - Merah Besar */
      .btn-danger {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 6px;
          background: linear-gradient(135deg, #fda4af, #fee2e2); /* red-300, red-100 */
          color: #991b1b; /* red-800 */
          padding: 11px 18px;
          border-radius: 12px;
          font-weight: 600;
          font-size: 14px;
          border: none;
          cursor: pointer;
          transition: 0.2s all;
          white-space: nowrap;
          box-shadow: 0 4px 12px rgba(253,164,175,.4);
      }
      .btn-danger:hover {
          background: linear-gradient(135deg, #fb7185, #fda4af); /* red-400, red-300 */
          transform: translateY(-2px);
          box-shadow: 0 6px 16px rgba(253,164,175,.5);
      }

      /* Tombol Danger Kecil (Hapus) - Merah Kecil */
      .btn-danger-sm {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 4px;
          background: linear-gradient(135deg, #fee2e2, #fef2f2); /* red-100, red-50 */
          color: #b91c1c; /* red-700 */
          padding: 7px 10px;
          border-radius: 8px;
          font-weight: 600;
          font-size: 12px;
          text-decoration: none;
          transition: 0.2s all;
          box-shadow: 0 2px 6px rgba(254,226,226,.3);
          border: 1px solid #fecaca; /* red-200 */
          cursor: pointer;
      }
      .btn-danger-sm:hover {
          background: linear-gradient(135deg, #fecaca, #fee2e2); /* red-200, red-100 */
          transform: translateY(-1px);
          box-shadow: 0 3px 10px rgba(254,226,226,.4);
      }
      
      /* Style tabel agar lebih bersih */
      .cart-table {
          min-width: 100%;
          width: 100%;
          border-collapse: collapse;
      }
      .cart-table th {
          font-size: 13px;
          color: #64748b;
          font-weight: 600;
          text-transform: uppercase;
          background-color: #f8fafc;
      }
      .cart-table th, .cart-table td {
          padding: 12px 10px;
          vertical-align: middle;
      }
      .cart-table tbody tr {
          border-top: 1px solid var(--border);
      }
      .cart-table tbody tr:hover {
          background-color: #fcfdff;
      }

  </style>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const updateForms = document.querySelectorAll('.update-qty-form');
          
          updateForms.forEach(form => {
              form.addEventListener('submit', function(e) {
                  e.preventDefault();
                  
                  const formData = new FormData(form);
                  const button = form.querySelector('button[type="submit"]');
                  const itemId = form.dataset.itemId;
                  const maxStock = parseInt(form.dataset.maxStock);
                  const qtyInput = form.querySelector('input[name="qty"]');
                  const qtyValue = parseInt(qtyInput.value);
                  const row = document.querySelector(`.cart-row[data-item-id="${itemId}"]`);
                  
                  // Validasi stok
                  if (qtyValue < 1) {
                      showToast('Jumlah minimal adalah 1', 'error');
                      return;
                  }
                  
                  if (qtyValue > maxStock) {
                      showToast('Stok tidak mencukupi! Tersedia hanya ' + maxStock + ' pcs.', 'error');
                      return;
                  }
                  
                  button.disabled = true;
                  
                  fetch(form.action, {
                      method: 'POST',
                      headers: {
                          'X-Requested-With': 'XMLHttpRequest',
                          'Accept': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                      },
                      body: formData
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          const subtotalCell = row.querySelector('.subtotal-cell');
                          subtotalCell.textContent = 'Rp ' + data.subtotal.toLocaleString('id-ID');
                          
                          const grandTotalCell = document.querySelector('.grand-total-cell');
                          grandTotalCell.textContent = 'Rp ' + data.grand_total.toLocaleString('id-ID');
                          
                          showToast(data.message, 'success');
                      } else {
                          showToast(data.message || 'Terjadi kesalahan', 'error');
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      showToast('Terjadi kesalahan', 'error');
                  })
                  .finally(() => {
                      button.disabled = false;
                  });
              });
          });
          
          const deleteForms = document.querySelectorAll('.delete-item-form');
          
          deleteForms.forEach(form => {
              form.addEventListener('submit', function(e) {
                  e.preventDefault();
                  
                  const formData = new FormData(form);
                  const button = form.querySelector('button[type="submit"]');
                  const itemId = form.dataset.itemId;
                  const row = document.querySelector(`.cart-row[data-item-id="${itemId}"]`);
                  
                  button.disabled = true;
                  
                  fetch(form.action, {
                      method: 'POST',
                      headers: {
                          'X-Requested-With': 'XMLHttpRequest',
                          'Accept': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                      },
                      body: formData
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          row.style.transition = 'opacity 0.3s, transform 0.3s';
                          row.style.opacity = '0';
                          row.style.transform = 'translateX(-20px)';
                          
                          setTimeout(() => {
                              row.remove();
                              
                              if (!data.is_empty) {
                                  const grandTotalCell = document.querySelector('.grand-total-cell');
                                  grandTotalCell.textContent = 'Rp ' + data.grand_total.toLocaleString('id-ID');
                              } else {
                                  const cartCard = document.querySelector('.cart-card');
                                  cartCard.innerHTML = `
                                      <div class="empty-state" style="padding-top: 20px;">
                                          <div class="empty-card">
                                              <div class="empty-icon">🛒</div>
                                              <div class="empty-text">Keranjang kamu masih kosong.</div>
                                              <a href="{{ route('products.index') }}" class="btn-primary" style="margin-top: 16px; text-decoration: none;">
                                                  Mulai Belanja
                                              </a>
                                          </div>
                                      </div>
                                  `;
                              }
                          }, 300);
                          
                          showToast(data.message, 'success');
                      } else {
                          showToast(data.message || 'Terjadi kesalahan', 'error');
                          button.disabled = false;
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      showToast('Terjadi kesalahan', 'error');
                      button.disabled = false;
                  });
              });
          });
      });

      document.getElementById('clear-cart-form').addEventListener('submit', function(e) {
          e.preventDefault();
          
          const form = this;
          const button = document.getElementById('clear-cart-btn');
          
          button.disabled = true;
          
          fetch(form.action, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'Accept': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                  'X-HTTP-Method-Override': 'DELETE'
              }
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  const cartCard = document.querySelector('.cart-card');
                  cartCard.innerHTML = `
                      <div class="empty-state" style="padding-top: 20px;">
                          <div class="empty-card">
                              <div class="empty-icon">🛒</div>
                              <div class="empty-text">Keranjang kamu masih kosong.</div>
                              <a href="{{ route('products.index') }}" class="btn-primary" style="margin-top: 16px; text-decoration: none;">
                                  Mulai Belanja
                              </a>
                          </div>
                      </div>
                  `;
                  
                  showToast(data.message, 'success');
              } else {
                  showToast(data.message || 'Terjadi kesalahan', 'error');
                  button.disabled = false;
              }
          })
          .catch(error => {
              console.error('Error:', error);
              showToast('Terjadi kesalahan', 'error');
              button.disabled = false;
          });
      });
  </script>

</x-app-layout>