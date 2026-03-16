<!DOCTYPE html>
<html class="light" lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Treviso')</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary":          "#32a5d7",
            "secondary":        "#47bcea",
            "accent":           "#8e989e",
            "background-light": "#f4f7f9",
            "background-dark":  "#111c21",
          },
          fontFamily: { "display": ["Inter","sans-serif"] },
          borderRadius: { "DEFAULT":"0.5rem","lg":"0.75rem","xl":"1rem","full":"9999px" },
        },
      },
    }
  </script>
  <style>
    .material-symbols-outlined { font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24 }
    [x-cloak] { display: none !important; }
  </style>
  @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col">

@auth
{{-- ── NAVBAR ──────────────────────────────────────────────────── --}}
<nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-50">
  <div class="max-w-screen-2xl mx-auto px-4 flex items-center h-14 gap-4">

    {{-- Logo + nombre --}}
    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-primary font-bold text-lg shrink-0">
      <svg class="size-6" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
        <path d="M24 45.8096C19.6865 45.8096 15.4698 44.5305 11.8832 42.134C8.29667 39.7376 5.50128 36.3314 3.85056 32.3462C2.19985 28.361 1.76794 23.9758 2.60947 19.7452C3.451 15.5145 5.52816 11.6284 8.57829 8.5783C11.6284 5.52817 15.5145 3.45101 19.7452 2.60948C23.9758 1.76795 28.361 2.19986 32.3462 3.85057C36.3314 5.50129 39.7376 8.29668 42.134 11.8833C44.5305 15.4698 45.8096 19.6865 45.8096 24L24 24L24 45.8096Z" fill="currentColor"/>
      </svg>
      Treviso
    </a>

    {{-- Menú desktop --}}
    <div class="hidden md:flex items-center gap-1 flex-1">

      <a href="{{ route('dashboard') }}"
         class="px-3 py-1.5 rounded text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }} transition-colors">
        Inicio
      </a>

      {{-- EXPLORADOR --}}
      <div class="relative group">
        <button class="flex items-center gap-1 px-3 py-1.5 rounded text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors">
          Explorador
          <span class="material-symbols-outlined text-base">expand_more</span>
        </button>
        <div class="absolute left-0 top-full mt-1 w-64 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50">
          <a href="{{ route('cfdi.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">description</span> CFDI's
          </a>
          <hr class="border-gray-100 dark:border-gray-700">
          <a href="{{ route('operaciones.depositos') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">account_balance</span>
            Depósitos pendientes
            @if(($navCounts['pendientesDeposito'] ?? 0) > 0)
              <span class="ml-auto bg-primary text-white text-xs rounded-full px-1.5 py-0.5">{{ $navCounts['pendientesDeposito'] }}</span>
            @endif
          </a>
          <a href="{{ route('operaciones.reembolsos') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">currency_exchange</span>
            Reembolsos pendientes
            @if(($navCounts['pendientesReembolso'] ?? 0) > 0)
              <span class="ml-auto bg-primary text-white text-xs rounded-full px-1.5 py-0.5">{{ $navCounts['pendientesReembolso'] }}</span>
            @endif
          </a>
          <hr class="border-gray-100 dark:border-gray-700">
          <a href="{{ route('cfdi.index') }}?tipo=comp" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">receipt_long</span> Complementos de Pago
          </a>
          <a href="{{ route('cfdi.index') }}?tipo=nc" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">note_alt</span> Notas de Crédito
          </a>
        </div>
      </div>

      {{-- CONTABILIZAR --}}
      <div class="relative group">
        <button class="flex items-center gap-1 px-3 py-1.5 rounded text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors">
          Contabilizar
          @if(($navCounts['totalPendientes'] ?? 0) > 0)
            <span class="bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">{{ $navCounts['totalPendientes'] }}</span>
          @endif
          <span class="material-symbols-outlined text-base">expand_more</span>
        </button>
        <div class="absolute left-0 top-full mt-1 w-72 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50">
          <a href="{{ route('contabilidad.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">task_alt</span>
            CFDI's
            @if(($navCounts['xmlPendientes'] ?? 0) > 0)
              <span class="ml-auto bg-orange-500 text-white text-xs rounded-full px-1.5 py-0.5">{{ $navCounts['xmlPendientes'] }}</span>
            @endif
          </a>
          <hr class="border-gray-100 dark:border-gray-700">
          <a href="{{ route('operaciones.depositos') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">account_balance</span>
            Depósitos
            @if(($navCounts['depPendientes'] ?? 0) > 0)
              <span class="ml-auto bg-orange-500 text-white text-xs rounded-full px-1.5 py-0.5">{{ $navCounts['depPendientes'] }}</span>
            @endif
          </a>
          <a href="{{ route('operaciones.reembolsos') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">currency_exchange</span>
            Reembolsos
            @if(($navCounts['reemPendientes'] ?? 0) > 0)
              <span class="ml-auto bg-orange-500 text-white text-xs rounded-full px-1.5 py-0.5">{{ $navCounts['reemPendientes'] }}</span>
            @endif
          </a>
          <hr class="border-gray-100 dark:border-gray-700">
          <a href="{{ route('operaciones.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">swap_horiz</span>
            Operaciones sin CFDI
            @if(($navCounts['ncfdiPendientes'] ?? 0) > 0)
              <span class="ml-auto bg-orange-500 text-white text-xs rounded-full px-1.5 py-0.5">{{ $navCounts['ncfdiPendientes'] }}</span>
            @endif
          </a>
        </div>
      </div>

      <a href="{{ route('reportes.index') }}"
         class="px-3 py-1.5 rounded text-sm font-medium {{ request()->routeIs('reportes*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }} transition-colors">
        Reportes
      </a>

      <a href="{{ route('clientes.index') }}"
         class="px-3 py-1.5 rounded text-sm font-medium {{ request()->routeIs('clientes*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }} transition-colors">
        Clientes
      </a>

      <a href="{{ route('notificaciones.index') }}"
         class="flex items-center gap-1 px-3 py-1.5 rounded text-sm font-medium {{ request()->routeIs('notificaciones*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:text-primary hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }} transition-colors">
        Notificaciones
        @if(($navCounts['noSaldados'] ?? 0) > 0)
          <span class="bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">{{ $navCounts['noSaldados'] }}</span>
        @endif
      </a>

      @if(auth()->user()->IDRol == 1)
      <div class="relative group">
        <button class="flex items-center gap-1 px-3 py-1.5 rounded text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors">
          Admin
          <span class="material-symbols-outlined text-base">expand_more</span>
        </button>
        <div class="absolute left-0 top-full mt-1 w-48 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50">
          <a href="{{ route('admin.empleados') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">group</span> Empleados
          </a>
          <a href="{{ route('admin.clientes') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-primary/5 hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-base">business</span> Clientes
          </a>
        </div>
      </div>
      @endif
    </div>

    {{-- Usuario + logout --}}
    <div class="ml-auto flex items-center gap-3 shrink-0">
      <span class="hidden sm:block text-sm text-gray-600 dark:text-gray-400 font-medium">
        {{ auth()->user()->empleado->NombreEmpleado ?? auth()->user()->NickUsuarioEmpleado }}
      </span>
      <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 dark:text-gray-300 dark:hover:bg-red-900/20 transition-colors">
          <span class="material-symbols-outlined text-base">logout</span>
          <span class="hidden sm:inline">Salir</span>
        </button>
      </form>
    </div>

  </div>
</nav>
@endauth

{{-- ── CONTENIDO ──────────────────────────────────────────────────── --}}
<main class="flex-1 max-w-screen-2xl mx-auto w-full px-4 py-6">

  @if(session('success'))
    <div class="mb-4 flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 p-3 text-sm text-green-700">
      <span class="material-symbols-outlined text-base">check_circle</span>
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="mb-4 flex items-center gap-2 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
      <span class="material-symbols-outlined text-base">error</span>
      {{ session('error') }}
    </div>
  @endif

  @yield('content')
</main>

{{-- ── FOOTER ─────────────────────────────────────────────────────── --}}
<footer class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 py-4 text-center text-xs text-accent">
  EspacioTreviso — Favor de reportar a
  <a href="mailto:soporte@naveho.com" class="text-primary hover:underline">Soporte</a>
  cualquier fallo o sugerencia. Copyright © {{ date('Y') }} Diseñado y desarrollado por
  <a href="https://naveho.com" target="_blank" class="text-primary hover:underline">Naveho Ingeniería S de RL de CV</a>.
  Todos los logotipos pertenecen a Treviso®.
</footer>

@stack('scripts')
</body>
</html>