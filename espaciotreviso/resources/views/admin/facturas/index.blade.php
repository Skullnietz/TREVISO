@extends('layouts.admin')
@section('title', 'Facturas')

@section('content')
<form method="GET" class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div>
            <label class="block text-xs font-medium text-accent mb-1">Cliente</label>
            <select name="cliente_id" class="form-select w-full rounded-lg border-gray-300 text-sm">
                <option value="">Todos</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" {{ request('cliente_id') == $c->id ? 'selected' : '' }}>{{ $c->razon_social }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-accent mb-1">Categoria</label>
            <select name="categoria" class="form-select w-full rounded-lg border-gray-300 text-sm">
                <option value="">Todas</option>
                <option value="factura_ingreso" {{ request('categoria') == 'factura_ingreso' ? 'selected' : '' }}>Ingresos</option>
                <option value="factura_egreso" {{ request('categoria') == 'factura_egreso' ? 'selected' : '' }}>Egresos</option>
                <option value="nota_credito" {{ request('categoria') == 'nota_credito' ? 'selected' : '' }}>Notas de Credito</option>
                <option value="complemento_pago" {{ request('categoria') == 'complemento_pago' ? 'selected' : '' }}>Complementos de Pago</option>
                <option value="nomina" {{ request('categoria') == 'nomina' ? 'selected' : '' }}>Nominas</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-accent mb-1">Estatus Pago</label>
            <select name="estatus_pago" class="form-select w-full rounded-lg border-gray-300 text-sm">
                <option value="">Todos</option>
                <option value="pendiente" {{ request('estatus_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="parcial" {{ request('estatus_pago') == 'parcial' ? 'selected' : '' }}>Parcial</option>
                <option value="pagado" {{ request('estatus_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-accent mb-1">Desde</label>
            <input name="fecha_desde" type="date" value="{{ request('fecha_desde') }}" class="form-input w-full rounded-lg border-gray-300 text-sm"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-accent mb-1">Hasta</label>
            <input name="fecha_hasta" type="date" value="{{ request('fecha_hasta') }}" class="form-input w-full rounded-lg border-gray-300 text-sm"/>
        </div>
    </div>
    <div class="flex items-center gap-3 mt-4">
        <input name="busqueda" type="text" value="{{ request('busqueda') }}" placeholder="Buscar por UUID, RFC, nombre..." class="form-input rounded-lg border-gray-300 text-sm flex-1"/>
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
            <span class="material-symbols-outlined text-lg">search</span>
            Filtrar
        </button>
        <a href="{{ route('admin.facturas.index') }}" class="px-4 py-2.5 text-accent hover:text-gray-900 text-sm">Limpiar</a>
    </div>
</form>

<div class="bg-white rounded-xl border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-accent uppercase">Cliente</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-accent uppercase">Emisor / Receptor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-accent uppercase">Categoria</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-accent uppercase">Fecha</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-accent uppercase">Monto</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-accent uppercase">Pago</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-accent uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($cfdis as $cfdi)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-xs text-gray-600">{{ $cfdi->cliente->razon_social ?? '' }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-900 text-xs">{{ $cfdi->nombre_emisor ?: $cfdi->rfc_emisor }}</p>
                        <p class="text-xs text-accent">→ {{ $cfdi->nombre_receptor ?: $cfdi->rfc_receptor }}</p>
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $catColores = [
                                'factura_ingreso' => 'bg-green-100 text-green-700',
                                'factura_egreso' => 'bg-orange-100 text-orange-700',
                                'nota_credito' => 'bg-purple-100 text-purple-700',
                                'complemento_pago' => 'bg-blue-100 text-blue-700',
                                'nomina' => 'bg-teal-100 text-teal-700',
                                'traslado' => 'bg-gray-100 text-gray-700',
                            ];
                            $catNombres = [
                                'factura_ingreso' => 'Ingreso',
                                'factura_egreso' => 'Egreso',
                                'nota_credito' => 'N. Credito',
                                'complemento_pago' => 'Comp. Pago',
                                'nomina' => 'Nomina',
                                'traslado' => 'Traslado',
                            ];
                        @endphp
                        <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $catColores[$cfdi->categoria] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $catNombres[$cfdi->categoria] ?? $cfdi->categoria }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-600">{{ $cfdi->fecha_emision->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-right font-mono text-sm font-medium text-gray-900">${{ number_format($cfdi->monto_total, 2) }}</td>
                    <td class="px-4 py-3">
                        @php
                            $pagoColores = ['pagado' => 'bg-green-100 text-green-700', 'parcial' => 'bg-yellow-100 text-yellow-700', 'pendiente' => 'bg-red-100 text-red-700'];
                        @endphp
                        <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $pagoColores[$cfdi->estatus_pago] ?? '' }}">
                            {{ ucfirst($cfdi->estatus_pago) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.facturas.show', $cfdi) }}" class="p-1.5 text-gray-400 hover:text-primary rounded-lg hover:bg-gray-100 transition-colors inline-flex">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-accent">No se encontraron facturas.</td>
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
