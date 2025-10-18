<section class="pass-scope">
  <div class="card">
    <div class="card-bg"></div>
    <div class="card-body">
      <h2 class="title">Perbarui Password</h2>
      <p class="subtitle">Pastikan password baru Anda aman dan mudah diingat.</p>

      <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <label class="label">Password Lama</label>
        <input type="password" name="current_password" required>

        <label class="label">Password Baru</label>
        <input type="password" name="password" required>

        <label class="label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </div>

  <style>
    .pass-scope *{
      font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif !important;
    }
    .pass-scope{--yellow-200:#f7e96b;--yellow-300:#f3db37;--green-200:#bff0c2;--green-300:#9ae2a0;
      --border:#e2e8f0;}
    .card{position:relative;background:#fff;border:1px solid var(--border);
      border-radius:16px;box-shadow:0 10px 30px rgba(16,24,40,.08);padding:24px;overflow:hidden;}
    .card-bg{position:absolute;inset:0;background:linear-gradient(135deg,var(--yellow-200),var(--green-200));
      opacity:.25;filter:blur(60px);}
    .card-body{position:relative;}
    .title{margin:0 0 6px;font-weight:700;font-size:18px;line-height:1.35;color:#0f172a;}
    .subtitle{margin:0 0 16px;color:#334155;font-size:14px;}
    .label{display:block;font-size:14px;color:#334155;margin-bottom:4px;font-weight:600;}
    input{width:100%;padding:10px 12px;border:1px solid var(--border);
      border-radius:12px;font-size:14px;margin-bottom:14px;outline:none;}
    input:focus{border-color:var(--yellow-300);box-shadow:0 0 0 3px rgba(247,233,107,.25);}
    .btn{padding:11px 18px;border-radius:12px;font-weight:700;font-size:14px;
      border:none;cursor:pointer;transition:.2s;}
    .btn-primary{background:linear-gradient(135deg,var(--yellow-300),var(--yellow-200));color:#713f12;}
    .btn-primary:hover{background:linear-gradient(135deg,var(--yellow-200),var(--yellow-100));transform:translateY(-2px);}
  </style>
</section>
