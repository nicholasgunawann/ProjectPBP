<section class="delete-scope">
  <div class="card">
    <div class="card-bg"></div>
    <div class="card-body">
      <h2 class="title">Hapus Akun</h2>
      <p class="subtitle">Setelah akun dihapus, semua data Anda akan hilang secara permanen.</p>

      <form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
        @csrf
        @method('delete')

        <label for="password" class="label">Masukkan Password</label>
        <input type="password" id="password" name="password" required placeholder="Password">

        <button type="button" class="btn btn-danger" onclick="showDeleteModal()">Hapus Akun</button>
      </form>
    </div>
  </div>

  <!-- Modal Konfirmasi -->
  <div id="deleteModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
      <div class="modal-icon">⚠️</div>
      <h3 class="modal-title">Hapus Akun?</h3>
      <p class="modal-message">Apakah Anda yakin ingin menghapus akun? Semua data akan hilang secara permanen dan tidak dapat dikembalikan!</p>
      <div class="modal-buttons">
        <button type="button" class="btn-modal btn-cancel" onclick="hideDeleteModal()">Batal</button>
        <button type="button" class="btn-modal btn-confirm" onclick="confirmDelete()">Ya, Hapus Akun</button>
      </div>
    </div>
  </div>

  <script>
    function showDeleteModal() {
      const passwordInput = document.getElementById('password');
      if (!passwordInput.value) {
        alert('Masukkan password terlebih dahulu!');
        passwordInput.focus();
        return;
      }
      document.getElementById('deleteModal').style.display = 'flex';
    }

    function hideDeleteModal() {
      document.getElementById('deleteModal').style.display = 'none';
    }

    function confirmDelete() {
      document.getElementById('deleteAccountForm').submit();
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
      if (e.target === this) {
        hideDeleteModal();
      }
    });
  </script>

  <style>
    .delete-scope *{
      font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif !important;
    }
    .delete-scope {
      --yellow-200:#f7e96b; --yellow-300:#f3db37;
      --green-200:#bff0c2; --green-300:#9ae2a0;
      --danger:#ef4444; --border:#e2e8f0;
    }

    .card {
      position: relative;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(16, 24, 40, .08);
      padding: 24px;
      overflow: hidden;
    }

    .card-bg {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--yellow-200), var(--green-200));
      opacity: .25;
      filter: blur(60px);
      z-index: 0;
    }

    .card-body {
      position: relative;
      z-index: 1;
    }

    .title {
      margin: 0 0 6px;
      font-weight: 700;
      font-size: 18px;
      line-height: 1.35;
      color: #0f172a;
    }

    .subtitle {
      margin: 0 0 16px;
      color: #334155;
      font-size: 14px;
    }

    .label {
      display: block;
      font-size: 14px;
      color: #334155;
      margin-bottom: 4px;
      font-weight: 600;
    }

    input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid var(--border);
      border-radius: 12px;
      font-size: 14px;
      margin-bottom: 16px;
      outline: none;
      background: #fff;
    }

    input:focus {
      border-color: var(--yellow-300);
      box-shadow: 0 0 0 3px rgba(247, 233, 107, .25);
    }

    .btn {
      width: 100%;
      padding: 11px 18px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 14px;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: .2s;
    }

    .btn-danger {
      background: linear-gradient(135deg, #fecaca, #fee2e2);
      color: #7f1d1d;
      box-shadow: 0 4px 12px rgba(254, 202, 202, .3);
    }

    .btn-danger:hover {
      background: linear-gradient(135deg, #fee2e2, #fecaca);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(254, 202, 202, .4);
    }

    /* Modal Styles */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(4px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      animation: fadeIn 0.2s;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .modal-box {
      background: #fff;
      border-radius: 16px;
      padding: 28px;
      max-width: 420px;
      width: 90%;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
      animation: slideUp 0.3s;
    }

    @keyframes slideUp {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .modal-icon {
      font-size: 48px;
      text-align: center;
      margin-bottom: 16px;
    }

    .modal-title {
      font-size: 20px;
      font-weight: 700;
      color: #111827;
      text-align: center;
      margin: 0 0 12px;
    }

    .modal-message {
      font-size: 14px;
      color: #6b7280;
      text-align: center;
      line-height: 1.6;
      margin: 0 0 24px;
    }

    .modal-buttons {
      display: flex;
      gap: 10px;
    }

    .btn-modal {
      flex: 1;
      padding: 11px 18px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 14px;
      border: none;
      cursor: pointer;
      transition: .2s;
    }

    .btn-cancel {
      background: #f3f4f6;
      color: #374151;
    }

    .btn-cancel:hover {
      background: #e5e7eb;
      transform: translateY(-1px);
    }

    .btn-confirm {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: #fff;
      box-shadow: 0 4px 12px rgba(239, 68, 68, .3);
    }

    .btn-confirm:hover {
      background: linear-gradient(135deg, #dc2626, #b91c1c);
      transform: translateY(-1px);
    }
  </style>
</section>
