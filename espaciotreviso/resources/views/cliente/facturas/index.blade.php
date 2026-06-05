@extends('layouts.cliente')
@section('title', $titulo)

@section('content')
<!-- Tabs de categoria -->
<div class="flex items-center gap-1 mb-6 bg-white rounded-xl border border-gray-200 p-1">
    @php
        $tabs = [
            'ingresos' => ['route' => 'cliente.facturas.ingresos', 'label' => 'Ingresos', 'icon' => 'trending_up'],
            'egresos' => ['route' => 'cliente.facturas.egresos', 'label' => 'Egresos', 'icon' => 'trending_down'],
            'notas_credito' => ['route' => 'cliente.facturas.notas_credito', 'label' => 'Notas de Credito', 'icon' => 'note_alt'],
            'banco' => ['route' => 'cliente.facturas.banco', 'label' => 'Banco', 'icon' => 'account_balance'],
        ];
    @endphp
    @foreach($tabs as $key => $tab)
        <a href="{{ route($tab['route']) }}" class="flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $categoria_activa === $key ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50' }}">
            <span class="material-symbols-outlined text-lg">{{ $tab['icon'] }}</span>
            {{ $tab['label'] }}
        </a>
    @endforeach
</div>

<!-- Filtros -->
<form method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
    <div class="flex flex-wrap items-center gap-3">
        <select name="estatus_pago" class="form-select rounded-lg border-gray-300 text-sm">
            <option value="">Todo estatus</option>
            <option value="pendiente" {{ request('estatus_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="parcial" {{ request('estatus_pago') == 'parcial' ? 'selected' : '' }}>Parcial</option>
            <option value="pagado" {{ request('estatus_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
        </select>
        <input name="fecha_desde" type="date" value="{{ request('fecha_desde') }}" class="form-input rounded-lg border-gray-300 text-sm" placeholder="Desde"/>
        <input name="fecha_hasta" type="date" value="{{ request('fecha_hasta') }}" class="form-input rounded-lg border-gray-300 text-sm" placeholder="Hasta"/>
        <input name="busqueda" type="text" value="{{ request('busqueda') }}" placeholder="Buscar RFC, nombre..." class="form-input rounded-lg border-gray-300 text-sm flex-1 min-w-[200px]"/>
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
            <span class="material-symbols-outlined text-lg">search</span>
            Buscar
        </button>
    </div>
</form>

<!-- Tabla de facturas -->
<div class="bg-white rounded-xl border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Folio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Emisor / Receptor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Fecha</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-accent uppercase">Monto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Estado de Pago</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-accent uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($cfdis as $cfdi)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $cfdi->serie ?? '' }}{{ $cfdi->folio ?? '-' }}</p>
                        <p class="text-xs text-accent font-mono">{{ \Illuminate\Support\Str::limit($cfdi->uuid, 12) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900 text-sm">{{ $cfdi->nombre_emisor ?: $cfdi->rfc_emisor }}</p>
                        <p class="text-xs text-accent">→ {{ $cfdi->nombre_receptor ?: $cfdi->rfc_receptor }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $cfdi->fecha_emision->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right font-mono font-medium text-gray-900">${{ number_format($cfdi->monto_total, 2) }}</td>
                    <td class="px-6 py-4">
                        @php
                            $pagoConfig = [
                                'pagado' => ['color' => 'bg-green-100 text-green-700', 'icon' => 'check_circle'],
                                'parcial' => ['color' => 'bg-yellow-100 text-yellow-700', 'icon' => 'schedule'],
                                'pendiente' => ['color' => 'bg-red-100 text-red-700', 'icon' => 'pending'],
                            ];
                            $cfg = $pagoConfig[$cfdi->estatus_pago] ?? $pagoConfig['pendiente'];
                        @endphp
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-full {{ $cfg['color'] }}">
                            <span class="material-symbols-outlined text-xs">{{ $cfg['icon'] }}</span>
                            {{ ucfirst($cfdi->estatus_pago) }}
                        </span>
                        @if($cfdi->estatus_pago === 'pagado' && $cfdi->fecha_pago)
                            <p class="text-xs text-accent mt-1">{{ $cfdi->fecha_pago->format('d/m/Y') }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('cliente.facturas.show', $cfdi) }}" class="p-2 text-gray-400 hover:text-primary rounded-lg hover:bg-gray-100 transition-colors" title="Ver detalle">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </a>
                            <a href="{{ route('cliente.facturas.download', $cfdi) }}" class="p-2 text-gray-400 hover:text-primary rounded-lg hover:bg-gray-100 transition-colors" title="Descargar XML">
                                <span class="material-symbols-outlined text-lg">download</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-accent">
                        <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">receipt_long</span>
                        <p>No hay facturas en esta categoria.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cfdis->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $cfdis->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
