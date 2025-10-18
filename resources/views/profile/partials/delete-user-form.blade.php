<section class="delete-scope">
  <div class="card">
    <div class="card-bg"></div>
    <div class="card-body">
      <h2 class="title">Hapus Akun</h2>
      <p class="subtitle">Setelah akun dihapus, semua data Anda akan hilang secara permanen.</p>

      <form method="post" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')

        <label for="password" class="label">Masukkan Password</label>
        <input type="password" id="password" name="password" required placeholder="Password">

        <div class="btn-group">
          <button type="submit" class="btn btn-danger">Hapus Akun</button>
          <a href="{{ route('dashboard') }}" class="btn btn-ghost">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <style>
    .delete-scope {
      --yellow-200:#f7e96b; --yellow-300:#f3db37;
      --green-200:#bff0c2; --green-300:#9ae2a0;
      --danger:#ef4444; --ink:#111827; --border:#e2e8f0;
    }

    .card {
      position: relative;
      background: rgba(255, 255, 255, 0.65);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.35);
      border-radius: 18px;
      box-shadow: 0 10px 30px rgba(16, 24, 40, .08);
      padding: 24px;
      overflow: hidden;
    }

    .card-bg {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--yellow-200), var(--green-200));
      opacity: .3;
      filter: blur(80px);
      z-index: 0;
    }

    .card-body {
      position: relative;
      z-index: 1;
    }

    .title {
      font: 700 18px ui-sans-serif;
      color: var(--ink);
      margin: 0 0 4px;
    }

    .subtitle {
      font-size: 14px;
      color: #475569;
      margin-bottom: 16px;
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
      background: rgba(255, 255, 255, 0.6);
      color: #111;
    }

    input:focus {
      border-color: var(--yellow-300);
      box-shadow: 0 0 0 3px rgba(247, 233, 107, .25);
      background: rgba(255, 255, 255, 0.8);
    }

    .btn-group {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 10px 16px;
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
    }

    .btn-ghost {
      background: rgba(255, 255, 255, 0.65);
      border: 1px solid var(--border);
      color: #111827;
    }

    .btn-ghost:hover {
      background: rgba(255, 255, 255, 0.9);
      transform: translateY(-1px);
    }
  </style>
</section>
