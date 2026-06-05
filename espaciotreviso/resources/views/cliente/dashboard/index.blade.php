@extends('layouts.cliente')
@section('title', 'Inicio')

@section('content')
<!-- Resumen -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-primary">receipt_long</span>
            <span class="text-sm text-accent">Total Facturas</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_facturas'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-red-500">pending</span>
            <span class="text-sm text-accent">Pendientes</span>
        </div>
        <p class="text-3xl font-bold text-red-600">{{ $stats['pendientes'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-green-500">check_circle</span>
            <span class="text-sm text-accent">Pagadas</span>
        </div>
        <p class="text-3xl font-bold text-green-600">{{ $stats['pagadas'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-orange-500">account_balance_wallet</span>
            <span class="text-sm text-accent">Monto Pendiente</span>
        </div>
        <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['monto_pendiente'], 2) }}</p>
    </div>
</div>

<!-- Facturas por mes -->
@if($facturas_por_mes->count() > 0)
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Facturas por Mes (Ultimos 6 meses)</h2>
    <div class="flex items-end gap-4 h-40">
        @foreach($facturas_por_mes as $mes)
        @php
            $maxTotal = $facturas_por_mes->max('total') ?: 1;
            $height = ($mes->total / $maxTotal) * 100;
        @endphp
        <div class="flex-1 flex flex-col items-center gap-2">
            <span class="text-xs font-medium text-gray-900">{{ $mes->total }}</span>
            <div class="w-full bg-primary/20 rounded-t-lg relative" style="height: {{ max($height, 5) }}%">
                <div class="absolute inset-0 bg-primary rounded-t-lg"></div>
            </div>
            <span class="text-xs text-accent">{{ \Carbon\Carbon::parse($mes->mes . '-01')->format('M Y') }}</span>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Observaciones recientes -->
<div class="bg-white rounded-xl border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">Observaciones Recientes</h2>
        <a href="{{ route('cliente.observaciones') }}" class="text-sm text-primary hover:text-secondary font-medium">Ver todas</a>
    </div>
    <div class="divide-y divide-gray-100">
        @forelse($observaciones_recientes as $obs)
        <div class="px-6 py-4 hover:bg-gray-50">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-sm {{ $obs->tipo === 'cliente' ? 'text-blue-500' : 'text-green-500' }}">
                    {{ $obs->tipo === 'cliente' ? 'person' : 'support_agent' }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-700 truncate">{{ $obs->mensaje }}</p>
                    <p class="text-xs text-accent">
                        {{ $obs->tipo === 'cliente' ? 'Tu' : 'Contador' }} - {{ $obs->created_at->diffForHumans() }}
                        @if($obs->cfdi)
                            | Factura: {{ \Illuminate\Support\Str::limit($obs->cfdi->uuid, 8) }}
                        @endif
                    </p>
                </div>
                @if(!$obs->leida && $obs->tipo === 'contador')
                    <span class="size-2 bg-red-500 rounded-full"></span>
                @endif
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-accent">
            <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">chat_bubble</span>
            <p class="text-sm">No hay observaciones recientes.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
