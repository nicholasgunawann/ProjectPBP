<x-app-layout>
  <x-slot name="header"></x-slot>

  <div class="auth-scope">
    <div class="wrap">
      <div class="auth-card">
        <div class="card-bg"></div>
        <div class="card-body">

          {{-- Session Status --}}
          <x-auth-session-status class="mb-4" :status="session('status')" />

          <h1 class="title">Masuk</h1>
          <p class="subtitle">Silakan login untuk melanjutkan.</p>

          <form method="POST" action="{{ route('login') }}" class="form">
            @csrf

            {{-- Email --}}
            <div class="field">
              <label for="email">Email</label>
              <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="field">
              <label for="password">Password</label>
              <input id="password" type="password" name="password" required autocomplete="current-password">
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Remember + Forgot --}}
            <div class="row between">
              <label class="remember">
                <input type="checkbox" name="remember" class="check-green">
                <span>Ingat saya</span>
              </label>

              @if (Route::has('password.request'))
                <a class="link" href="{{ route('password.request') }}">
                  Lupa password?
                </a>
              @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">Masuk</button>

            {{-- Link ke Register --}}
            @if (Route::has('register'))
              <div class="divider">Belum punya akun?</div>
              <a href="{{ route('register') }}" class="btn btn-accent t-center">Daftar</a>
            @endif
          </form>

        </div>
      </div>
    </div>
  </div>

  <style>
    .auth-scope{
      --yellow-100:#fef3a8; --yellow-200:#f7e96b; --yellow-300:#f3db37;
      --green-100:#d7f5da; --green-200:#bff0c2; --green-300:#22c55e;
      --ink:#0f172a; --muted:#64748b; --border:#e2e8f0; --soft:#f9fafb;
      --shadow:0 10px 30px rgba(16,24,40,.08);
    }
    .auth-scope .wrap{
      max-width: 640px;
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

    .row{display:flex;gap:10px;align-items:center}
    .between{justify-content:space-between}
    .remember{display:inline-flex;align-items:center;gap:8px;color:#475569;font-size:14px}
    .link{color:#0f172a;font-weight:600;text-decoration:none}
    .link:hover{text-decoration:underline}

    /* ✅ Checkbox hijau */
    .check-green {
      appearance: none;
      width: 18px;
      height: 18px;
      border: 2px solid var(--green-300);
      border-radius: 6px;
      display: inline-block;
      position: relative;
      cursor: pointer;
      transition: all 0.2s;
    }
    .check-green:checked {
      background-color: var(--green-300);
      border-color: var(--green-300);
    }
    .check-green:checked::after {
      content: "";
      position: absolute;
      left: 4px;
      top: 0px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 2px 2px 0;
      transform: rotate(45deg);
    }
    .check-green:hover {
      box-shadow: 0 0 0 3px rgba(34,197,94,.25);
    }

    .btn{
      display:inline-flex;justify-content:center;align-items:center;gap:6px;
      border-radius:12px;padding:12px 16px;font-weight:800;font-size:14px;
      border:1px solid transparent;cursor:pointer;text-decoration:none;transition:.2s;width:100%;
    }
    .btn-primary{background:linear-gradient(135deg,var(--yellow-300),var(--yellow-200));color:#713f12;box-shadow:0 6px 16px rgba(243,219,55,.35)}
    .btn-primary:hover{background:linear-gradient(135deg,var(--yellow-200),var(--yellow-100));transform:translateY(-2px)}
    .btn-accent{background:linear-gradient(135deg,#9ae2a0,#bff0c2);color:#14532d;box-shadow:0 6px 16px rgba(154,226,160,.35)}
    .btn-accent:hover{background:linear-gradient(135deg,#bff0c2,#d7f5da);transform:translateY(-2px)}

    .divider{margin:8px 0;text-align:center;color:#64748b;font-size:12px}
    .t-center{text-align:center}
  </style>
</x-app-layout>
