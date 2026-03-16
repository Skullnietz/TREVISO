<!DOCTYPE html>
<html lang="es" id="htmlRoot" class="dark">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','EspacioTreviso') - Treviso</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                primary:         "#32a5d7",
                "primary-hover": "#47bcea",
                accent:          "#8e989e",
                "dk-bg":         "#111c21",
                "dk-surface":    "#1a2428",
                "dk-border":     "#2d3f47",
                "dk-input":      "#243038",
                "dk-hover":      "#243038",
                "dk-text":       "#F8F9FA",
                "lt-bg":         "#f1f5f9",
                "lt-surface":    "#ffffff",
                "lt-border":     "#e2e8f0",
                "lt-input":      "#f1f5f9",
                "lt-hover":      "#f1f5f9",
                "lt-text":       "#1e293b",
            },
            fontFamily: { display: ["Inter","sans-serif"] },
            width: { sidebar: "220px" },
        },
    },
};
</script>
<style>
.material-symbols-outlined {
    font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;
}
::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #32a5d7; border-radius: 9999px; }

/* Active nav item */
.nav-item.active {
    background: rgba(50,165,215,.15);
    color: #32a5d7;
    font-weight: 600;
}
/* Light mode hover */
.nav-item:not(.active):hover { background:#f1f5f9; color:#1e293b; }
/* Dark mode hover */
.dark .nav-item:not(.active):hover { background:#243038; color:#F8F9FA; }

/* Mobile sidebar open state (JS adds .is-open) */
#sidebar.is-open { transform: translateX(0) !important; }

.nav-item.search-hidden { display: none !important; }

/* ════════════════════════════════════════════════════
   TOM SELECT — EspacioTreviso Theme
   Soporta dark/light mode via clase .dark en <html>
════════════════════════════════════════════════════ */

/* El wrapper hereda las clases del <select> original.
   Reseteamos lo que Tailwind form-select agrega visualmente */
.ts-wrapper.form-select {
    background-image: none !important;
    padding: 0 !important;
    height: auto !important;
}

/* ── Control (caja visible) ── */
.ts-control,
.ts-wrapper.single .ts-control {
    border-radius: 0.5rem !important;
    min-height: 2.25rem !important;
    padding: 0 2rem 0 0.625rem !important;
    display: flex !important;
    align-items: center !important;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
    cursor: pointer !important;
    transition: border-color 150ms ease, box-shadow 150ms ease !important;
    /* Light */
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    color: #1e293b !important;
    box-shadow: none !important;
}
.dark .ts-control,
.dark .ts-wrapper.single .ts-control {
    background: #243038 !important;
    border-color: #2d3f47 !important;
    color: #F8F9FA !important;
}

/* Focus ring */
.ts-wrapper.focus .ts-control {
    border-color: #32a5d7 !important;
    box-shadow: 0 0 0 3px rgba(50,165,215,0.2) !important;
    outline: none !important;
}

/* Placeholder */
.ts-control .placeholder {
    color: #8e989e !important;
}

/* Caret — ícono de flecha */
.ts-wrapper.single .ts-control:after {
    border-color: #8e989e transparent transparent !important;
    right: 0.625rem !important;
}
.dark .ts-wrapper.single .ts-control:after {
    border-color: #8e989e transparent transparent !important;
}
.ts-wrapper.single.input-active .ts-control:after,
.ts-wrapper.single.dropdown-active .ts-control:after {
    border-color: transparent transparent #32a5d7 !important;
}

/* ── Dropdown panel ── */
.ts-dropdown {
    border-radius: 0.5rem !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.06) !important;
    font-size: 0.875rem !important;
    z-index: 9999 !important;
    margin-top: 4px !important;
    /* Light */
    background: #ffffff !important;
    color: #1e293b !important;
}
.dark .ts-dropdown {
    background: #1a2428 !important;
    border-color: #2d3f47 !important;
    color: #F8F9FA !important;
}

/* Buscador interno del dropdown */
.ts-dropdown .ts-dropdown-header {
    padding: 0.5rem !important;
    border-bottom: 1px solid #e2e8f0 !important;
}
.dark .ts-dropdown .ts-dropdown-header {
    border-color: #2d3f47 !important;
}

/* ── Opciones ── */
.ts-dropdown .option {
    padding: 0.45rem 0.75rem !important;
    cursor: pointer !important;
    transition: background 80ms ease !important;
    color: #1e293b !important;
    font-size: 0.875rem !important;
    border-radius: 0 !important;
}
.dark .ts-dropdown .option {
    color: #F8F9FA !important;
}
.ts-dropdown .option:hover,
.ts-dropdown .option.active {
    background: rgba(50,165,215,0.1) !important;
    color: #32a5d7 !important;
}
.dark .ts-dropdown .option:hover,
.dark .ts-dropdown .option.active {
    background: rgba(71,188,234,0.15) !important;
    color: #47bcea !important;
}
/* Opción actualmente seleccionada */
.ts-dropdown .option.selected,
.ts-dropdown [data-selectable].selected {
    font-weight: 600 !important;
    color: #32a5d7 !important;
    background: rgba(50,165,215,0.08) !important;
}
.dark .ts-dropdown .option.selected,
.dark .ts-dropdown [data-selectable].selected {
    color: #47bcea !important;
    background: rgba(71,188,234,0.12) !important;
}

/* Sin resultados */
.ts-dropdown .no-results {
    color: #8e989e !important;
    padding: 0.625rem 0.75rem !important;
    text-align: center !important;
    font-size: 0.875rem !important;
    font-style: italic !important;
}

/* Scroll interno del dropdown */
.ts-dropdown-content {
    max-height: 230px !important;
    overflow-y: auto !important;
    scrollbar-width: thin !important;
    scrollbar-color: #32a5d7 transparent !important;
}
.ts-dropdown-content::-webkit-scrollbar { width: 4px; }
.ts-dropdown-content::-webkit-scrollbar-track { background: transparent; }
.ts-dropdown-content::-webkit-scrollbar-thumb { background: #32a5d7; border-radius: 4px; }

/* Separador optgroup */
.ts-dropdown .optgroup-header {
    color: #8e989e !important;
    font-size: 0.7rem !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.08em !important;
    padding: 0.5rem 0.75rem 0.25rem !important;
    background: transparent !important;
}

/* Responsive: full width siempre en mobile */
@media (max-width: 1023px) {
    .ts-wrapper {
        width: 100% !important;
    }
}
</style>
@yield('head')
</head>

<body class="bg-lt-bg dark:bg-dk-bg text-lt-text dark:text-dk-text font-display antialiased">

{{-- ═══════════════════════════════════════════════════════════════
     MOBILE ONLY: backdrop overlay
════════════════════════════════════════════════════════════════ --}}
<div id="sidebarOverlay"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden"
     onclick="closeSidebar()"></div>

{{-- ═══════════════════════════════════════════════════════════════
     ROOT FLEX CONTAINER
════════════════════════════════════════════════════════════════ --}}
<div class="flex h-screen overflow-hidden">

{{-- ── SIDEBAR ────────────────────────────────────────────────── --}}
{{--
    Desktop (≥1024px): part of the flex flow, takes 220px.
    Mobile (<1024px): fixed overlay, hidden by default (-translate-x-full),
                      shown when .is-open added by JS.
--}}
<aside id="sidebar"
       class="flex flex-col flex-shrink-0 overflow-hidden
              w-[220px]
              bg-lt-surface border-r border-lt-border
              dark:bg-dk-surface dark:border-dk-border
              max-lg:fixed max-lg:inset-y-0 max-lg:left-0 max-lg:z-50
              max-lg:-translate-x-full
              transition-transform duration-300 ease-in-out">

    {{-- Logo / Brand --}}
    <div class="flex items-center justify-between h-16 px-4 flex-shrink-0
                border-b border-lt-border dark:border-dk-border">
        <a href="{{ route('dashboard') }}" class="flex items-center min-w-0">
            {{-- Pill oscuro en modo claro para que el logo blanco sea visible --}}
            <span class="inline-flex items-center rounded-lg px-2.5 py-1
                         bg-[#1e7ea1] dark:bg-transparent transition-colors duration-200">
                <img src="{{ asset('img/logo_treviso.png') }}" alt="Treviso"
                     class="h-7 w-auto max-w-[160px] object-contain">
            </span>
        </a>
        <button onclick="closeSidebar()"
                class="lg:hidden p-1 rounded text-accent hover:text-lt-text dark:hover:text-dk-text">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
    </div>

    {{-- Mini search --}}
    <div class="px-3 pt-3 pb-2">
        <label class="flex items-center gap-2 h-8 rounded-lg px-2.5
                      bg-lt-input border border-lt-border
                      dark:bg-dk-input dark:border-dk-border
                      focus-within:border-primary dark:focus-within:border-primary
                      transition-colors">
            <span class="material-symbols-outlined text-accent text-[17px] flex-shrink-0">search</span>
            <input id="sidebarSearch" type="text" placeholder="Buscar…"
                   class="bg-transparent flex-1 text-xs text-lt-text dark:text-dk-text
                          placeholder:text-accent focus:outline-none border-none min-w-0"/>
        </label>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-2 py-1 space-y-0.5">

        <a href="{{ route('dashboard') }}"
           class="nav-item group flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-accent transition-colors
                  {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           data-label="Dashboard Inicio">
            <span class="material-symbols-outlined text-[19px] flex-shrink-0">dashboard</span>
            <span class="text-[13px] font-medium truncate">Dashboard</span>
        </a>

        <a href="{{ route('cfdi.index') }}"
           class="nav-item group flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-accent transition-colors
                  {{ request()->routeIs('cfdi.*') ? 'active' : '' }}"
           data-label="CFDI Facturas XML Documentos">
            <span class="material-symbols-outlined text-[19px] flex-shrink-0">receipt_long</span>
            <span class="text-[13px] font-medium truncate">CFDI / Facturas</span>
        </a>

        <a href="{{ route('operaciones.index') }}"
           class="nav-item group flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-accent transition-colors
                  {{ request()->routeIs('operaciones.*') ? 'active' : '' }}"
           data-label="Operaciones Depósitos Reembolsos Movimientos">
            <span class="material-symbols-outlined text-[19px] flex-shrink-0">swap_horiz</span>
            <span class="text-[13px] font-medium truncate">Operaciones</span>
        </a>

        <a href="{{ route('contabilidad.index') }}"
           class="nav-item group flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-accent transition-colors
                  {{ request()->routeIs('contabilidad.*') ? 'active' : '' }}"
           data-label="Contabilidad Contabilizar Pendientes">
            <span class="material-symbols-outlined text-[19px] flex-shrink-0">calculate</span>
            <span class="text-[13px] font-medium truncate">Contabilidad</span>
            @if(!empty($navCounts['totalPendientes']) && $navCounts['totalPendientes'] > 0)
                <span class="ml-auto text-[10px] font-bold bg-primary text-white rounded-full
                             px-1.5 py-px min-w-[18px] text-center flex-shrink-0 leading-4">{{ $navCounts['totalPendientes'] }}</span>
            @endif
        </a>

        <a href="{{ route('reportes.index') }}"
           class="nav-item group flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-accent transition-colors
                  {{ request()->routeIs('reportes.*') ? 'active' : '' }}"
           data-label="Reportes Estadísticas Gráficas">
            <span class="material-symbols-outlined text-[19px] flex-shrink-0">bar_chart</span>
            <span class="text-[13px] font-medium truncate">Reportes</span>
        </a>

        <a href="{{ route('clientes.index') }}"
           class="nav-item group flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-accent transition-colors
                  {{ request()->routeIs('clientes.*') ? 'active' : '' }}"
           data-label="Clientes Empresas Cuentas">
            <span class="material-symbols-outlined text-[19px] flex-shrink-0">groups</span>
            <span class="text-[13px] font-medium truncate">Clientes</span>
        </a>

        <a href="{{ route('notificaciones.index') }}"
           class="nav-item group flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-accent transition-colors
                  {{ request()->routeIs('notificaciones.*') ? 'active' : '' }}"
           data-label="Notificaciones Avisos Alertas Mensajes">
            <span class="material-symbols-outlined text-[19px] flex-shrink-0">notifications</span>
            <span class="text-[13px] font-medium truncate">Notificaciones</span>
            @if(!empty($navCounts['notifNoLeidas']) && $navCounts['notifNoLeidas'] > 0)
                <span class="ml-auto text-[10px] font-bold bg-red-500 text-white rounded-full
                             px-1.5 py-px min-w-[18px] text-center flex-shrink-0 leading-4">{{ $navCounts['notifNoLeidas'] }}</span>
            @endif
        </a>

        @if(Auth::user()->IDRol == 1)
        <div class="pt-4 pb-1.5 px-3">
            <p class="text-[9px] font-bold text-accent uppercase tracking-[0.12em]">Administración</p>
        </div>
        <a href="{{ route('admin.index') }}"
           class="nav-item group flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-accent transition-colors
                  {{ request()->routeIs('admin.*') ? 'active' : '' }}"
           data-label="Admin Administración Empleados Configuración Sistema">
            <span class="material-symbols-outlined text-[19px] flex-shrink-0">admin_panel_settings</span>
            <span class="text-[13px] font-medium truncate">Administración</span>
        </a>
        @endif
    </nav>

    {{-- User card --}}
    <div class="px-3 py-3 border-t border-lt-border dark:border-dk-border flex-shrink-0">
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-8 h-8 rounded-full bg-primary/20 text-primary font-bold text-xs
                        flex items-center justify-center flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->NickUsuarioEmpleado ?? 'U', 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[13px] font-semibold text-lt-text dark:text-dk-text truncate leading-tight">
                    {{ Auth::user()->NickUsuarioEmpleado }}
                </p>
                <p class="text-[11px] text-accent truncate leading-tight">
                    {{ Auth::user()->IDRol == 1 ? 'Administrador' : 'Colaborador' }}
                </p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="flex-shrink-0">
                @csrf
                <button type="submit" title="Cerrar sesión"
                        class="text-accent hover:text-red-400 transition-colors p-1">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ── MAIN COLUMN ─────────────────────────────────────────────── --}}
<div class="flex flex-col flex-1 overflow-hidden min-w-0">

    {{-- ── TOPBAR ────────────────────────────────────────────── --}}
    <header class="flex items-center h-14 px-4 gap-3 flex-shrink-0
                   bg-lt-surface border-b border-lt-border
                   dark:bg-dk-surface dark:border-dk-border">

        {{-- Hamburger — mobile only --}}
        <button onclick="openSidebar()"
                class="lg:hidden flex items-center justify-center w-8 h-8 rounded-lg text-accent
                       bg-lt-input border border-lt-border hover:text-primary
                       dark:bg-dk-input dark:border-dk-border flex-shrink-0">
            <span class="material-symbols-outlined text-[19px]">menu</span>
        </button>

        {{-- Breadcrumb / page title --}}
        <div class="hidden sm:flex items-center gap-1.5 text-sm text-accent min-w-0 flex-shrink-0">
            <span class="text-primary font-semibold text-[13px]">@yield('page-title', 'Dashboard')</span>
        </div>

        {{-- Spacer --}}
        <div class="flex-1"></div>

        {{-- Header search (syncs with sidebar search) --}}
        <label class="hidden sm:flex items-center gap-2 h-8 rounded-lg px-3 w-52
                      bg-lt-input border border-lt-border
                      dark:bg-dk-input dark:border-dk-border
                      focus-within:border-primary dark:focus-within:border-primary transition-colors">
            <span class="material-symbols-outlined text-accent text-[17px] flex-shrink-0">search</span>
            <input id="headerSearch" type="text" placeholder="Buscar menú…"
                   class="bg-transparent flex-1 text-xs text-lt-text dark:text-dk-text
                          placeholder:text-accent focus:outline-none border-none min-w-0"/>
        </label>

        {{-- Theme toggle --}}
        <button onclick="toggleTheme()" title="Cambiar tema"
                class="flex items-center justify-center w-8 h-8 rounded-lg text-accent flex-shrink-0
                       bg-lt-input border border-lt-border hover:text-primary
                       dark:bg-dk-input dark:border-dk-border transition-colors">
            <span class="material-symbols-outlined text-[19px]" id="themeIcon">light_mode</span>
        </button>

        {{-- Notifications bell --}}
        <a href="{{ route('notificaciones.index') }}"
           class="relative flex items-center justify-center w-8 h-8 rounded-lg text-accent flex-shrink-0
                  bg-lt-input border border-lt-border hover:text-primary
                  dark:bg-dk-input dark:border-dk-border transition-colors">
            <span class="material-symbols-outlined text-[19px]">notifications</span>
            @if(!empty($navCounts['notifNoLeidas']) && $navCounts['notifNoLeidas'] > 0)
                <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[9px] font-bold
                             rounded-full w-4 h-4 flex items-center justify-center leading-none">
                    {{ min($navCounts['notifNoLeidas'], 9) }}
                </span>
            @endif
        </a>

        {{-- Avatar + dropdown --}}
        <div class="relative group flex-shrink-0">
            <button class="w-8 h-8 rounded-full bg-primary/20 text-primary font-bold text-xs
                           border-2 border-primary/30 flex items-center justify-center hover:bg-primary/30 transition-colors">
                {{ strtoupper(substr(Auth::user()->NickUsuarioEmpleado ?? 'U', 0, 2)) }}
            </button>
            {{-- Dropdown --}}
            <div class="absolute right-0 top-full mt-2 w-52 rounded-xl shadow-2xl border z-50
                        bg-lt-surface border-lt-border
                        dark:bg-dk-surface dark:border-dk-border
                        opacity-0 invisible group-hover:opacity-100 group-hover:visible
                        transition-all duration-150 origin-top-right scale-95 group-hover:scale-100">
                <div class="px-4 py-3 border-b border-lt-border dark:border-dk-border">
                    <p class="text-[13px] font-bold text-lt-text dark:text-dk-text leading-tight">{{ Auth::user()->NickUsuarioEmpleado }}</p>
                    <p class="text-[11px] text-accent mt-0.5">{{ Auth::user()->IDRol == 1 ? 'Administrador' : 'Colaborador' }}</p>
                </div>
                <div class="p-1.5 space-y-0.5">
                    <button onclick="toggleTheme()"
                            class="w-full flex items-center gap-2.5 px-3 py-2 text-[13px] rounded-lg
                                   text-lt-text dark:text-dk-text hover:bg-lt-hover dark:hover:bg-dk-hover transition-colors text-left">
                        <span class="material-symbols-outlined text-[17px] text-accent" id="themeIcon2">light_mode</span>
                        <span id="themeLabel">Modo oscuro</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-3 py-2 text-[13px] rounded-lg
                                       text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <span class="material-symbols-outlined text-[17px]">logout</span>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success') || session('error'))
    <div class="px-4 sm:px-6 pt-4 flex-shrink-0 space-y-2">
        @if(session('success'))
        <div class="flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm
                    bg-green-50 border border-green-200 text-green-700
                    dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm
                    bg-red-50 border border-red-200 text-red-700
                    dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
            <span class="material-symbols-outlined text-[18px]">error</span>
            {{ session('error') }}
        </div>
        @endif
    </div>
    @endif

    {{-- Page content --}}
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-lt-bg dark:bg-dk-bg">
        @yield('content')
    </main>
</div>

</div>{{-- end root flex --}}

{{-- ─── Scripts ──────────────────────────────────────────────── --}}
<script>
// ── Mobile sidebar ──────────────────────────────────────────────
function openSidebar() {
    var s = document.getElementById('sidebar');
    var o = document.getElementById('sidebarOverlay');
    s.classList.add('is-open');
    o.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    var s = document.getElementById('sidebar');
    var o = document.getElementById('sidebarOverlay');
    s.classList.remove('is-open');
    o.classList.add('hidden');
    document.body.style.overflow = '';
}

// Close sidebar on route change (mobile)
window.addEventListener('resize', function () {
    if (window.innerWidth >= 1024) { closeSidebar(); }
});

// ── Theme ───────────────────────────────────────────────────────
function applyTheme(dark) {
    var html  = document.getElementById('htmlRoot');
    var i1    = document.getElementById('themeIcon');
    var i2    = document.getElementById('themeIcon2');
    var label = document.getElementById('themeLabel');
    if (dark) {
        html.classList.add('dark');
        if (i1)    i1.textContent    = 'light_mode';
        if (i2)    i2.textContent    = 'light_mode';
        if (label) label.textContent = 'Modo oscuro';
    } else {
        html.classList.remove('dark');
        if (i1)    i1.textContent    = 'dark_mode';
        if (i2)    i2.textContent    = 'dark_mode';
        if (label) label.textContent = 'Modo claro';
    }
    document.dispatchEvent(new CustomEvent('themechange', { detail: { dark: dark } }));
}
function toggleTheme() {
    var isDark = document.getElementById('htmlRoot').classList.contains('dark');
    localStorage.setItem('theme', isDark ? 'light' : 'dark');
    applyTheme(!isDark);
}
// Init — default dark unless explicitly set to light
(function () { applyTheme(localStorage.getItem('theme') !== 'light'); })();

// ── Sidebar nav search ──────────────────────────────────────────
function filterNav(q) {
    document.querySelectorAll('#sidebar .nav-item[data-label]').forEach(function (el) {
        var hit = !q
            || el.dataset.label.toLowerCase().includes(q)
            || el.textContent.toLowerCase().includes(q);
        el.classList.toggle('search-hidden', !hit);
    });
}
['sidebarSearch', 'headerSearch'].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) el.addEventListener('input', function () { filterNav(this.value.toLowerCase().trim()); });
});
</script>
{{-- ── Tom Select: inicialización automática ────────────── --}}
<script>
(function () {
    'use strict';

    // Opciones base para todos los selects
    var TS_OPTS = {
        allowEmptyOption: true,   // permite opción vacía "— Todos —"
        maxOptions:       null,   // sin límite de opciones visibles
        sortField:        false,  // mantiene el orden original
        searchField:      ['text'],
        // Al abrir el dropdown, limpia el texto del input para que el usuario
        // pueda escribir directamente sin tener que borrar el valor previo
        onFocus: function () {
            this.setTextboxValue('');
            this.refreshOptions(false);
        },
        render: {
            no_results: function () {
                return '<div class="no-results">Sin resultados</div>';
            }
        }
    };

    function initAllSelects() {
        document.querySelectorAll('select:not([data-no-ts])').forEach(function (el) {
            // Evitar doble inicialización
            if (el.tomselect) return;
            new TomSelect(el, Object.assign({}, TS_OPTS));
        });
    }

    // Init al cargar la página
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllSelects);
    } else {
        initAllSelects();
    }

    // Re-init si alguna vista agrega selects dinámicamente
    window.TomSelectInit = initAllSelects;
})();
</script>
@yield('scripts')
</body>
</html>
