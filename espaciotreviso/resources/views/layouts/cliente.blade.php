<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Treviso - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#32a5d7",
                        "secondary": "#47bcea",
                        "accent": "#8e989e",
                        "background-light": "#f4f7f9",
                        "background-dark": "#111c21",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-background-light font-display">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-full z-10">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="size-8 text-primary">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 45.8096C19.6865 45.8096 15.4698 44.5305 11.8832 42.134C8.29667 39.7376 5.50128 36.3314 3.85056 32.3462C2.19985 28.361 1.76794 23.9758 2.60947 19.7452C3.451 15.5145 5.52816 11.6284 8.57829 8.5783C11.6284 5.52817 15.5145 3.45101 19.7452 2.60948C23.9758 1.76795 28.361 2.19986 32.3462 3.85057C36.3314 5.50129 39.7376 8.29668 42.134 11.8833C44.5305 15.4698 45.8096 19.6865 45.8096 24L24 24L24 45.8096Z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Treviso</h2>
                        <p class="text-xs text-accent">Portal Cliente</p>
                    </div>
                </div>
            </div>

            <!-- Client info -->
            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                <p class="text-xs text-accent uppercase tracking-wider font-medium">Cliente</p>
                <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->cliente->razon_social }}</p>
                <p class="text-xs text-accent">RFC: {{ Auth::user()->cliente->rfc }}</p>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('cliente.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cliente.dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="material-symbols-outlined text-xl">dashboard</span>
                    Inicio
                </a>

                <p class="px-3 pt-4 pb-1 text-xs text-accent uppercase tracking-wider font-medium">Mis Facturas</p>
                <a href="{{ route('cliente.facturas.ingresos') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cliente.facturas.ingresos') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="material-symbols-outlined text-xl">trending_up</span>
                    Ingresos
                </a>
                <a href="{{ route('cliente.facturas.egresos') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cliente.facturas.egresos') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="material-symbols-outlined text-xl">trending_down</span>
                    Egresos
                </a>
                <a href="{{ route('cliente.facturas.notas_credito') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cliente.facturas.notas_credito') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="material-symbols-outlined text-xl">note_alt</span>
                    Notas de Credito
                </a>
                <a href="{{ route('cliente.facturas.banco') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cliente.facturas.banco') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="material-symbols-outlined text-xl">account_balance</span>
                    Banco
                </a>

                <p class="px-3 pt-4 pb-1 text-xs text-accent uppercase tracking-wider font-medium">Pagos</p>
                <a href="{{ route('cliente.pagos') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cliente.pagos') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="material-symbols-outlined text-xl">payments</span>
                    Complementos de Pago
                </a>

                <p class="px-3 pt-4 pb-1 text-xs text-accent uppercase tracking-wider font-medium">Nomina</p>
                <a href="{{ route('cliente.nominas') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cliente.nominas') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="material-symbols-outlined text-xl">badge</span>
                    Nominas
                </a>

                <div class="border-t border-gray-100 my-3"></div>
                <a href="{{ route('cliente.observaciones') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('cliente.observaciones') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="material-symbols-outlined text-xl">chat</span>
                    Observaciones
                    @php
                        $obsNoLeidas = \App\Observacion::where('tipo', 'contador')
                            ->where('leida', false)
                            ->whereHas('cfdi', fn($q) => $q->where('cliente_id', Auth::user()->cliente_id))
                            ->count();
                    @endphp
                    @if($obsNoLeidas > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $obsNoLeidas }}</span>
                    @endif
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('cliente.logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors w-full">
                        <span class="material-symbols-outlined text-xl">logout</span>
                        Cerrar Sesion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 ml-64">
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <h1 class="text-xl font-bold text-gray-900">@yield('title')</h1>
            </header>

            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-500">check_circle</span>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-500">error</span>
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
