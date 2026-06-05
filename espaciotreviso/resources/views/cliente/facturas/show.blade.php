@extends('layouts.cliente')
@section('title', 'Detalle de Factura')

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Info general -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-sm text-accent font-mono">{{ $cfdi->uuid }}</p>
                @if($cfdi->serie || $cfdi->folio)
                    <p class="text-lg font-semibold text-gray-900">{{ $cfdi->serie }}{{ $cfdi->folio }}</p>
                @endif
            </div>
            <div class="flex items-center gap-2">
                @php
                    $pagoConfig = [
                        'pagado' => ['color' => 'bg-green-100 text-green-700', 'icon' => 'check_circle'],
                        'parcial' => ['color' => 'bg-yellow-100 text-yellow-700', 'icon' => 'schedule'],
                        'pendiente' => ['color' => 'bg-red-100 text-red-700', 'icon' => 'pending'],
                    ];
                    $cfg = $pagoConfig[$cfdi->estatus_pago] ?? $pagoConfig['pendiente'];
                @endphp
                <span class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium rounded-full {{ $cfg['color'] }}">
                    <span class="material-symbols-outlined text-sm">{{ $cfg['icon'] }}</span>
                    {{ ucfirst($cfdi->estatus_pago) }}
                </span>
                <span class="inline-flex px-3 py-1.5 text-sm font-medium rounded-full {{ $cfdi->estatus_sat === 'vigente' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    SAT: {{ ucfirst($cfdi->estatus_sat) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            <div>
                <p class="text-xs text-accent mb-1">Emisor</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->nombre_emisor }}</p>
                <p class="text-xs text-accent font-mono">{{ $cfdi->rfc_emisor }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Receptor</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->nombre_receptor }}</p>
                <p class="text-xs text-accent font-mono">{{ $cfdi->rfc_receptor }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Monto Total</p>
                <p class="text-3xl font-bold text-gray-900">${{ number_format($cfdi->monto_total, 2) }}</p>
                <p class="text-xs text-accent">{{ $cfdi->moneda }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Fecha de Emision</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->fecha_emision->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Metodo de Pago</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->metodo_pago ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Forma de Pago</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->forma_pago ?? '-' }}</p>
            </div>
        </div>

        @if($cfdi->estatus_pago !== 'pendiente')
        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <h3 class="text-sm font-semibold text-green-800 mb-2">Informacion de Pago</h3>
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-xs text-green-600">Metodo</p>
                    <p class="font-medium text-green-800">{{ $cfdi->metodo_pago_real ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-green-600">Fecha de Pago</p>
                    <p class="font-medium text-green-800">{{ $cfdi->fecha_pago ? $cfdi->fecha_pago->format('d/m/Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-green-600">Referencia</p>
                    <p class="font-medium text-green-800">{{ $cfdi->referencia_pago ?? '-' }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('cliente.facturas.download', $cfdi) }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                <span class="material-symbols-outlined text-lg">download</span>
                Descargar XML
            </a>
        </div>
    </div>

    <!-- Observaciones -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Observaciones</h2>

        <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
            @forelse($cfdi->observaciones->sortBy('created_at') as $obs)
            <div class="flex gap-3 {{ $obs->tipo === 'contador' ? 'flex-row-reverse' : '' }}">
                <div class="size-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $obs->tipo === 'cliente' ? 'bg-blue-100' : 'bg-green-100' }}">
                    <span class="material-symbols-outlined text-sm {{ $obs->tipo === 'cliente' ? 'text-blue-600' : 'text-green-600' }}">
                        {{ $obs->tipo === 'cliente' ? 'person' : 'support_agent' }}
                    </span>
                </div>
                <div class="max-w-md p-3 rounded-lg {{ $obs->tipo === 'cliente' ? 'bg-blue-50' : 'bg-green-50' }}">
                    <p class="text-sm text-gray-700">{{ $obs->mensaje }}</p>
                    <p class="text-xs text-accent mt-1">
                        {{ $obs->tipo === 'cliente' ? 'Tu' : 'Contador' }} - {{ $obs->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
            @empty
            <p class="text-sm text-accent text-center py-4">Sin observaciones sobre esta factura.</p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('cliente.observaciones.store') }}" class="flex gap-3">
            @csrf
            <input type="hidden" name="cfdi_id" value="{{ $cfdi->id }}"/>
            <input name="mensaje" type="text" required class="form-input flex-1 rounded-lg border-gray-300 text-sm" placeholder="Escribe una observacion para tu contador..." maxlength="2000"/>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
                <span class="material-symbols-outlined text-lg">send</span>
                Enviar
            </button>
        </form>
    </div>
</div>
@endsection
