<section class="profile-scope">
  <div class="card">
    <div class="card-bg"></div>
    <div class="card-body">
      <h2 class="title">Informasi Profil</h2>
      <p class="subtitle">Perbarui data profil Anda di bawah ini.</p>

      <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <label class="label">Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

        <label class="label">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </div>

  <style>
    .profile-scope{--yellow-200:#f7e96b;--yellow-300:#f3db37;--green-200:#bff0c2;--green-300:#9ae2a0;--border:#e2e8f0;}
    .card{position:relative;background:#fff;border:1px solid var(--border);
      border-radius:16px;box-shadow:0 10px 30px rgba(16,24,40,.08);padding:24px;overflow:hidden;}
    .card-bg{position:absolute;inset:0;background:linear-gradient(135deg,var(--yellow-200),var(--green-200));opacity:.25;filter:blur(60px);}
    .card-body{position:relative;}
    .title{font:700 18px ui-sans-serif;color:#111827;margin:0 0 4px;}
    .subtitle{font-size:14px;color:#475569;margin-bottom:16px;}
    .label{display:block;font-size:14px;color:#334155;margin-bottom:4px;font-weight:600;}
    input{width:100%;padding:10px 12px;border:1px solid var(--border);
      border-radius:12px;font-size:14px;margin-bottom:14px;outline:none;}
    input:focus{border-color:var(--yellow-300);box-shadow:0 0 0 3px rgba(247,233,107,.25);}
    .btn{padding:11px 18px;border-radius:12px;font-weight:700;font-size:14px;border:none;cursor:pointer;transition:.2s;}
    .btn-primary{background:linear-gradient(135deg,var(--yellow-300),var(--yellow-200));color:#713f12;}
    .btn-primary:hover{background:linear-gradient(135deg,var(--yellow-200),var(--yellow-100));transform:translateY(-2px);}
  </style>
</section>
