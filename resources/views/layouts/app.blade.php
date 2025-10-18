{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', 'SixStore') }}</title>
      <link rel="icon" type="image/png" href="{{ asset('MainLogoSixStore.png') }}">

      {{-- Fonts --}}
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

      {{-- Alpine.js CDN (backup) --}}
      <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

      {{-- Vite assets --}}
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="font-sans antialiased bg-white">
      <div class="min-h-screen flex flex-col">
          {{-- NAVBAR --}}
          @include('layouts.navigation')

          {{-- HEADER (Tetap putih clean) --}}
          @if (isset($header))
              <header class="bg-white shadow relative z-10">
                  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                      {{ $header }}
                  </div>
              </header>
          @endif

          {{-- PAGE CONTENT dengan efek keren --}}
          <main class="relative flex-1 overflow-hidden" style="min-height: calc(100vh - 140px);">
              {{-- Background Layers --}}
              <div class="bg-base"></div>
              <div class="bg-blob blob1"></div>
              <div class="bg-blob blob2"></div>
              <div class="bg-pattern"></div>

              {{-- Konten --}}
              <div class="relative z-10 py-8">
                  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                      {{ $slot }}
                  </div>
              </div>
          </main>

          {{-- TOAST NOTIFICATION SUCCESS --}}
          @if(session('success'))
          <div x-data="{ show: true }" 
               x-show="show" 
               x-init="setTimeout(() => show = false, 3000)"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform translate-y-2"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               x-transition:leave="transition ease-in duration-300"
               x-transition:leave-start="opacity-100"
               x-transition:leave-end="opacity-0"
               class="toast-notification toast-success">
              <div class="toast-content">
                  <svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span class="toast-message">{{ session('success') }}</span>
                  <button @click="show = false" class="toast-close">
                      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                  </button>
              </div>
          </div>
          @endif

          {{-- TOAST NOTIFICATION ERROR --}}
          @if(session('error'))
          <div x-data="{ show: true }" 
               x-show="show" 
               x-init="setTimeout(() => show = false, 3000)"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform translate-y-2"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               x-transition:leave="transition ease-in duration-300"
               x-transition:leave-start="opacity-100"
               x-transition:leave-end="opacity-0"
               class="toast-notification toast-error">
              <div class="toast-content">
                  <svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                  <span class="toast-message">{{ session('error') }}</span>
                  <button @click="show = false" class="toast-close">
                      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                  </button>
              </div>
          </div>
          @endif
      </div>

      {{-- STYLE ZONE --}}
      <style>
        /* ========== BASE BACKGROUND (untuk main) ========== */
        .bg-base {
          position: absolute;
          inset: 0;
          background: linear-gradient(135deg, #d4f1e8, #c8f0e0, #b8e8d4);
          background-size: 200% 200%;
          animation: gradientFlow 10s ease infinite;
          z-index: 1;
        }
        @keyframes gradientFlow {
          0% { background-position: 0% 50%; }
          50% { background-position: 100% 50%; }
          100% { background-position: 0% 50%; }
        }

        /* ========== MOVING BLOBS ========== */
        .bg-blob {
          position: absolute;
          border-radius: 50%;
          filter: blur(100px);
          opacity: 0.35;
          animation: floatBlob 20s ease-in-out infinite alternate;
          z-index: 2;
        }
        .blob1 {
          top: -10%;
          left: -15%;
          width: 500px;
          height: 500px;
          background: radial-gradient(circle at center, #ddf101, transparent 70%);
          animation-delay: 0s;
        }
        .blob2 {
          bottom: -15%;
          right: -10%;
          width: 480px;
          height: 480px;
          background: radial-gradient(circle at center, #bbf305, transparent 70%);
          animation-delay: 3s;
        }
        @keyframes floatBlob {
          0% { transform: translateY(0) scale(1); }
          50% { transform: translateY(-30px) scale(1.1); }
          100% { transform: translateY(0) scale(1); }
        }

        /* ========== DOT TEXTURE ========== */
        .bg-pattern {
          position: absolute;
          inset: 0;
          background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
          background-size: 24px 24px;
          pointer-events: none;
          z-index: 3;
        }

        /* ========== CONTENT LAYER ========== */
        main > .relative.z-10 {
          position: relative;
          z-index: 10;
          color: #000000;
        }

        /* ========== TOAST NOTIFICATION ========== */
        .toast-notification {
          position: fixed;
          top: 20px;
          right: 20px;
          z-index: 9999;
          max-width: 400px;
        }
        
        /* Toast Success */
        .toast-success .toast-content {
          display: flex;
          align-items: center;
          gap: 12px;
          background: linear-gradient(135deg, #d7f5da, #bff0c2);
          border: 2px solid #9ae2a0;
          border-radius: 14px;
          padding: 14px 18px;
          box-shadow: 0 10px 30px rgba(6, 95, 70, 0.2);
          backdrop-filter: blur(10px);
        }
        .toast-success .toast-icon {
          width: 24px;
          height: 24px;
          color: #065f46;
          flex-shrink: 0;
        }
        .toast-success .toast-message {
          flex: 1;
          font-size: 14px;
          font-weight: 600;
          color: #064e3b;
        }
        
        /* Toast Error */
        .toast-error .toast-content {
          display: flex;
          align-items: center;
          gap: 12px;
          background: linear-gradient(135deg, #fee2e2, #fecaca);
          border: 2px solid #fca5a5;
          border-radius: 14px;
          padding: 14px 18px;
          box-shadow: 0 10px 30px rgba(220, 38, 38, 0.2);
          backdrop-filter: blur(10px);
        }
        .toast-error .toast-icon {
          width: 24px;
          height: 24px;
          color: #991b1b;
          flex-shrink: 0;
        }
        .toast-error .toast-message {
          flex: 1;
          font-size: 14px;
          font-weight: 600;
          color: #7f1d1d;
        }
        .toast-close {
          width: 20px;
          height: 20px;
          color: #065f46;
          cursor: pointer;
          background: transparent;
          border: none;
          padding: 0;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: 4px;
          transition: all 0.2s;
        }
        .toast-close:hover {
          background: rgba(6, 95, 70, 0.1);
        }
        .toast-close svg {
          width: 16px;
          height: 16px;
        }
      </style>

      <script>
        function showToast(message, type = 'success') {
          const container = document.getElementById('toast-container');
          if (!container) {
            const newContainer = document.createElement('div');
            newContainer.id = 'toast-container';
            newContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
            document.body.appendChild(newContainer);
          }
          
          const toast = document.createElement('div');
          toast.className = `toast toast-${type}`;
          toast.style.cssText = 'margin-bottom: 12px; animation: slideInRight 0.3s ease-out;';
          
          const icon = type === 'success' 
            ? '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>'
            : '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>';
          
          toast.innerHTML = `
            <div class="toast-content">
              ${icon}
              <span class="toast-message">${message}</span>
              <button class="toast-close" onclick="this.parentElement.parentElement.remove()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          `;
          
          const toastContainer = document.getElementById('toast-container');
          toastContainer.appendChild(toast);
          
          setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
          }, 3000);
        }

        // Add animation keyframes
        if (!document.getElementById('toast-animations')) {
          const style = document.createElement('style');
          style.id = 'toast-animations';
          style.textContent = `
            @keyframes slideInRight {
              from { transform: translateX(400px); opacity: 0; }
              to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
              from { transform: translateX(0); opacity: 1; }
              to { transform: translateX(400px); opacity: 0; }
            }
          `;
          document.head.appendChild(style);
        }
      </script>
  </body>
</html>
