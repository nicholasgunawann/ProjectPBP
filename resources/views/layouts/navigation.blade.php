{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false }" class="bg-white/90 border-b border-gray-200 backdrop-blur-md shadow-sm relative z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center">
          <img src="{{ asset('logo-sixstore.png') }}" alt="SixStore Logo" class="h-7 w-auto object-contain" />
        </a>

        <!-- Tabs -->
        <div class="hidden sm:flex items-center ml-20">
          @auth
            @if(auth()->user()->role === 'user')
              <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="tab-chip">
                {{ __('Dashboard') }}
              </x-nav-link>
            @endif

            @if(auth()->user()->role === 'admin')
              <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="tab-chip">
                {{ __('Dashboard') }}
              </x-nav-link>
            @endif

            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="tab-chip">
              {{ __('Produk') }}
            </x-nav-link>

            @if(auth()->user()->role === 'user')
              <x-nav-link :href="route('cart.show')" :active="request()->routeIs('cart.*')" class="tab-chip">
                {{ __('Keranjang') }}
              </x-nav-link>
              <x-nav-link :href="route('orders.mine')" :active="request()->is('orders-saya')" class="tab-chip">
                {{ __('Pesanan Saya') }}
              </x-nav-link>
            @endif

            @if(auth()->user()->role === 'admin')
              <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*') || request()->routeIs('admin.orders.*') || request()->routeIs('admin.categories.*')" class="tab-chip">
                {{ __('Manage') }}
              </x-nav-link>
            @endif
          @endauth
        </div>
      </div>

      <!-- Right Side (Desktop) -->
      <div class="hidden sm:flex sm:items-center">
        @auth
          <x-dropdown align="right" width="48">
            {{-- Trigger (profil) --}}
            <x-slot name="trigger">
              @php
                $name = Auth::user()->name ?? 'User';
                $initials = collect(explode(' ', trim($name)))->map(fn($p)=>mb_substr($p,0,1))->take(2)->implode('');
              @endphp
              <button class="profile-trigger group" aria-label="User menu">
                <span class="avatar">{{ $initials }}</span>
                <span class="name">{{ \Illuminate\Support\Str::limit($name, 18) }}</span>
                <svg class="caret" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/>
                </svg>
              </button>
            </x-slot>

            {{-- Dropdown content: Profile + Logout (COMPACT) --}}
            <x-slot name="content">
              <a class="menu-item" href="{{ route('profile.edit') }}">
                <svg class="mi" viewBox="0 0 24 24" fill="none"><path d="M12 14a5 5 0 100-10 5 5 0 000 10zM20 21a8 8 0 10-16 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Profile</span>
              </a>

              <div class="menu-divider"></div>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="menu-item danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();">
                  <svg class="mi" viewBox="0 0 24 24" fill="none"><path d="M15 12H3m12 0l-4-4m4 4l-4 4M21 3v18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  <span>Log Out</span>
                </a>
              </form>
            </x-slot>
          </x-dropdown>
        @else
          <div class="flex items-center gap-3">
            <!-- Login -->
            <a href="{{ route('login') }}" class="auth-btn auth-btn--ghost">
              <svg class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none">
                <path d="M15 8l4 4-4 4M3 12h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Login
            </a>

            <!-- Register -->
            <a href="{{ route('register') }}" class="auth-btn auth-btn--primary">
              <svg class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none">
                <path d="M16 11V7m-2 2h4M12 7a4 4 0 11-8 0 4 4 0 018 0zM3 21a7 7 0 0114 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Register
            </a>
          </div>
        @endauth
      </div>

      <!-- Hamburger (Mobile) -->
      <div class="-me-2 flex items-center sm:hidden">
        <button @click="open = ! open"
          class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-green-700 hover:bg-green-50 focus:outline-none transition">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Responsive Menu -->
  <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 backdrop-blur">
    <div class="pt-2 pb-3 space-y-1">
      <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
        {{ __('Produk') }}
      </x-responsive-nav-link>

      @auth
        @if(auth()->user()->role === 'user')
          <x-responsive-nav-link :href="route('cart.show')" :active="request()->routeIs('cart.*')">
            {{ __('Keranjang') }}
          </x-responsive-nav-link>
          <x-responsive-nav-link :href="route('orders.mine')" :active="request()->is('orders-saya')">
            {{ __('Pesanan Saya') }}
          </x-responsive-nav-link>
        @endif

        @if(auth()->user()->role === 'admin')
          <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            {{ __('Dashboard') }}
          </x-responsive-nav-link>
          <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
            {{ __('Produk') }}
          </x-responsive-nav-link>
          <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
            {{ __('Pesanan') }}
          </x-responsive-nav-link>
          <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
            {{ __('Kategori') }}
          </x-responsive-nav-link>
        @endif
      @endauth
    </div>

    <!-- Responsive Settings -->
    <div class="pt-4 pb-4 border-t border-gray-200">
      @auth
        <div class="px-4">
          <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
          <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>
        <div class="mt-3 space-y-1">
          <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
              {{ __('Log Out') }}
            </x-responsive-nav-link>
          </form>
        </div>
      @else
        <div class="px-4 py-3 flex gap-3">
          <a href="{{ route('login') }}" class="auth-btn auth-btn--ghost w-1/2 justify-center">Login</a>
          <a href="{{ route('register') }}" class="auth-btn auth-btn--primary w-1/2 justify-center">Register</a>
        </div>
      @endauth
    </div>
  </div>

  <style>
    :root{
      --mint-1:#d4f1e8; --mint-2:#c8f0e0; --mint-3:#b8e8d4; --mint-underline:#a6ebc9;
      --mint-text:#064e3b;
    }

    /* ========== Capsule Tabs (mint) ========== */
    .tab-chip{
      --border: linear-gradient(135deg,var(--mint-1),var(--mint-3));
      position:relative; display:inline-block; margin-left:.9rem;
      padding:.34rem .85rem; font-size:.8rem; font-weight:600; color:var(--mint-text);
      border-radius:9999px;
      background:linear-gradient(#fff,#fff) padding-box, var(--border) border-box;
      border:2px solid transparent;
      transition:transform .2s ease, box-shadow .2s ease;
      box-shadow:0 1px 2px rgba(0,0,0,.05);
    }
    .tab-chip:hover{
      box-shadow:0 3px 10px rgba(6,95,70,.12);
      transform:translateY(-1px);
    }
    .tab-chip:hover::after{
      content:""; position:absolute; left:.9rem; right:.9rem; bottom:2px;
      height:2px; border-radius:2px; background:var(--mint-underline);
    }
    .tab-chip[aria-current="page"], .tab-chip[data-active="true"]{
      background:linear-gradient(var(--mint-2),var(--mint-3)) padding-box,var(--border) border-box;
    }

    /* ========== Profile Trigger (compact) ========== */
    .profile-trigger{
      display:inline-flex; align-items:center; gap:.5rem;
      padding:.38rem .55rem; border-radius:12px;
      background:#ffffff; border:1px solid rgba(184,232,212,.9);
      color:#065f46; transition:all .2s ease;
      box-shadow:0 1px 2px rgba(0,0,0,.05);
      font-size:.82rem;
      cursor:pointer;
      position:relative;
      z-index:10;
    }
    .profile-trigger:hover{
      background:var(--mint-2); color:var(--mint-text); border-color:#a6ebc9;
      transform:translateY(-1px);
      box-shadow:0 2px 4px rgba(0,0,0,.08);
    }
    .profile-trigger .avatar{
      width:26px; height:26px; border-radius:9999px;
      background:linear-gradient(135deg,var(--mint-1),var(--mint-2),var(--mint-3));
      display:inline-flex; align-items:center; justify-content:center;
      font-size:.75rem; font-weight:700; color:var(--mint-text);
    }
    .profile-trigger .name{ font-weight:600; font-size:.82rem; }
    .profile-trigger .caret{ width:14px; height:14px; opacity:.8; }

    /* ========== Dropdown (Profile + Logout COMPACT) ========== */
    .menu-item{
      display:flex; align-items:center; gap:.5rem;
      padding:.4rem .7rem; font-size:.8rem; color:var(--mint-text);
      transition:all .18s ease; text-decoration:none;
    }
    .menu-item .mi{ width:16px; height:16px; opacity:.9; }
    .menu-item:hover{ background:#eafff3; color:#065f46; }
    .menu-divider{ height:1px; background:rgba(184,232,212,.9); }
    .menu-item.danger{ color:#b42318; }
    .menu-item.danger:hover{ background:#ffe9e6; color:#912018; }

    /* ========== Auth Buttons (Login & Register) ========== */
    .auth-btn{
      display:inline-flex; align-items:center; border-radius:10px;
      font-weight:600; font-size:.8rem;
      padding:.4rem .8rem; transition:all .25s ease; text-decoration:none;
    }
    .auth-btn--ghost{
      background:transparent; color:#065f46; border:1.5px solid #b8e8d4;
    }
    .auth-btn--ghost:hover{
      background:#c8f0e0; color:#064e3b; border-color:#a6ebc9;
      box-shadow:0 2px 6px rgba(6,95,70,0.12);
      transform:translateY(-1px);
    }
    .auth-btn--primary{
      background:linear-gradient(135deg,#c8f0e0,#b8e8d4);
      color:#064e3b; border:1.5px solid #a6ebc9;
    }
    .auth-btn--primary:hover{
      background:linear-gradient(135deg,#bfead9,#ade3cc);
      border-color:#9adfbe;
      box-shadow:0 3px 8px rgba(6,95,70,0.14);
      transform:translateY(-1px);
    }
    .auth-btn svg{ flex-shrink:0; }
  </style>
</nav>
