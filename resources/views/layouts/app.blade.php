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
      </div>

      {{-- STYLE ZONE --}}
      <style>
        /* ========== BASE BACKGROUND (untuk main) ========== */
        .bg-base {
          position: absolute;
          inset: 0;
          background: linear-gradient(135deg, #13c81c, #2ac034, #05ff11);
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
      </style>
  </body>
</html>
