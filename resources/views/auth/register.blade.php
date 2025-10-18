<x-app-layout>
  <x-slot name="header"></x-slot>

  <div class="auth-scope">
    <div class="wrap">
      <div class="auth-card">
        <div class="card-bg"></div>
        <div class="card-body">

          <h1 class="title">Register</h1>
          <p class="subtitle">Buat akun barumu.</p>

          <form method="POST" action="{{ route('register') }}" class="form">
            @csrf

            {{-- Name --}}
            <div class="field">
              <label for="name">Nama</label>
              <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="field">
              <label for="email">Email</label>
              <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="field">
              <label for="password">Password</label>
              <input id="password" type="password" name="password" required autocomplete="new-password">
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div class="field">
              <label for="password_confirmation">Konfirmasi Password</label>
              <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">Register</button>

            {{-- Link ke Login --}}
            @if (Route::has('login'))
              <div class="divider">Sudah punya akun?</div>
              <a href="{{ route('login') }}" class="btn btn-accent t-center">Login</a>
            @endif
          </form>

        </div>
      </div>
    </div>
  </div>

  <style>
    .auth-scope{
      --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
      --green-100:#d7f5da; --green-200:#bff0c2; --green-300:#9ae2a0;
      --ink:#0f172a; --muted:#64748b; --border:#e2e8f0; --soft:#f9fafb;
      --shadow:0 10px 30px rgba(16,24,40,.08);
    }
    .auth-scope .wrap{
      max-width: 680px;
      margin: 32px auto;
      padding: 0 16px;
    }

    .auth-card{position:relative;width:100%;background:#fff;border:1px solid var(--border);border-radius:18px;box-shadow:var(--shadow);overflow:hidden}
    .card-bg{position:absolute;inset:0;background:linear-gradient(135deg,var(--yellow-100),var(--green-100));opacity:.35;filter:blur(60px)}
    .card-body{position:relative;padding:24px}

    .title{margin:0 0 4px;font:800 22px/1.3 ui-sans-serif,system-ui;color:var(--ink)}
    .subtitle{margin:0 0 16px;color:#334155;font-size:14px}

    .form{display:flex;flex-direction:column;gap:12px}
    .field{display:flex;flex-direction:column;gap:6px}
    .field label{font-size:13px;color:#334155;font-weight:600}
    .field input{width:100%;padding:11px 12px;border:1px solid var(--border);border-radius:12px;background:#fff;font-size:14px;outline:none;transition:.2s}
    .field input:focus{border-color:var(--yellow-300);box-shadow:0 0 0 3px rgba(247,233,107,.2)}

    .btn{
      display:inline-flex;justify-content:center;align-items:center;gap:6px;
      border-radius:12px;padding:12px 16px;font-weight:800;font-size:14px;
      border:1px solid transparent;cursor:pointer;text-decoration:none;transition:.2s;width:100%;
    }
    .btn-primary{background:linear-gradient(135deg,var(--yellow-300),var(--yellow-200));color:#713f12;box-shadow:0 6px 16px rgba(243,219,55,.35)}
    .btn-primary:hover{background:linear-gradient(135deg,var(--yellow-200),var(--yellow-100));transform:translateY(-2px)}
    .btn-accent{background:linear-gradient(135deg,var(--green-300),var(--green-200));color:#14532d;box-shadow:0 6px 16px rgba(154,226,160,.35)}
    .btn-accent:hover{background:linear-gradient(135deg,var(--green-200),var(--green-100));transform:translateY(-2px)}

    .divider{margin:8px 0;text-align:center;color:#64748b;font-size:12px}
    .t-center{text-align:center}
  </style>
</x-app-layout>
