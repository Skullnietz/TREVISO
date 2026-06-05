@extends('layouts.admin')
@section('title', 'Factura - ' . $cfdi->uuid)

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Info general -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Detalle del CFDI</h2>
                <p class="text-sm text-accent font-mono">{{ $cfdi->uuid }}</p>
            </div>
            <div class="flex items-center gap-2">
                @php
                    $pagoColores = ['pagado' => 'bg-green-100 text-green-700', 'parcial' => 'bg-yellow-100 text-yellow-700', 'pendiente' => 'bg-red-100 text-red-700'];
                @endphp
                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $pagoColores[$cfdi->estatus_pago] ?? '' }}">
                    {{ ucfirst($cfdi->estatus_pago) }}
                </span>
                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $cfdi->estatus_sat === 'vigente' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    SAT: {{ ucfirst($cfdi->estatus_sat) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
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
                <p class="text-2xl font-bold text-gray-900">${{ number_format($cfdi->monto_total, 2) }}</p>
                <p class="text-xs text-accent">{{ $cfdi->moneda }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Fecha Emision</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->fecha_emision->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Serie / Folio</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->serie ?? '-' }} / {{ $cfdi->folio ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Metodo de Pago</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->metodo_pago ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Forma de Pago</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->forma_pago ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-accent mb-1">Cliente</p>
                <p class="text-sm font-medium text-gray-900">{{ $cfdi->cliente->razon_social }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.facturas.download', $cfdi) }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                <span class="material-symbols-outlined text-lg">download</span>
                Descargar XML
            </a>
        </div>
    </div>

    <!-- Actualizar pago -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Estado de Pago</h2>
        <form method="POST" action="{{ route('admin.facturas.pago', $cfdi) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-accent mb-1">Estatus</label>
                    <select name="estatus_pago" class="form-select w-full rounded-lg border-gray-300 text-sm">
                        <option value="pendiente" {{ $cfdi->estatus_pago === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="parcial" {{ $cfdi->estatus_pago === 'parcial' ? 'selected' : '' }}>Parcial</option>
                        <option value="pagado" {{ $cfdi->estatus_pago === 'pagado' ? 'selected' : '' }}>Pagado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-accent mb-1">Metodo de Pago Real</label>
                    <input name="metodo_pago_real" type="text" value="{{ $cfdi->metodo_pago_real }}" class="form-input w-full rounded-lg border-gray-300 text-sm" placeholder="Transferencia, Cheque..."/>
                </div>
                <div>
                    <label class="block text-xs font-medium text-accent mb-1">Fecha de Pago</label>
                    <input name="fecha_pago" type="date" value="{{ $cfdi->fecha_pago ? $cfdi->fecha_pago->format('Y-m-d') : '' }}" class="form-input w-full rounded-lg border-gray-300 text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-medium text-accent mb-1">Referencia</label>
                    <input name="referencia_pago" type="text" value="{{ $cfdi->referencia_pago }}" class="form-input w-full rounded-lg border-gray-300 text-sm" placeholder="No. referencia"/>
                </div>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
                <span class="material-symbols-outlined text-lg">save</span>
                Actualizar Pago
            </button>
        </form>
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
                    <p class="text-xs text-accent mt-1">{{ $obs->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-accent text-center py-4">Sin observaciones.</p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('admin.facturas.observacion', $cfdi) }}" class="flex gap-3">
            @csrf
            <input name="mensaje" type="text" required class="form-input flex-1 rounded-lg border-gray-300 text-sm" placeholder="Responder al cliente..." maxlength="2000"/>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
                <span class="material-symbols-outlined text-lg">send</span>
                Enviar
            </button>
        </form>
    </div>
</div>
@endsection
