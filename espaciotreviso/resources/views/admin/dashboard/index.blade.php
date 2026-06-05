@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-primary">business</span>
            <span class="text-sm text-accent">Clientes Activos</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_clientes'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-green-500">verified</span>
            <span class="text-sm text-accent">e.firma Activas</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['efirma_activas'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-red-500">gpp_maybe</span>
            <span class="text-sm text-accent">e.firma Vencidas</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['efirma_vencidas'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-primary">receipt_long</span>
            <span class="text-sm text-accent">CFDIs Este Mes</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['cfdis_mes'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-orange-500">chat</span>
            <span class="text-sm text-accent">Observaciones</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['observaciones_pendientes'] }}</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Solicitudes de Descarga Recientes</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Periodo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">CFDIs</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($solicitudes_recientes as $solicitud)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $solicitud->cliente->razon_social ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $solicitud->tipo === 'emitida' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                            {{ ucfirst($solicitud->tipo) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $solicitud->fecha_inicio->format('d/m/Y') }} - {{ $solicitud->fecha_fin->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $colores = [
                                'pendiente' => 'bg-gray-100 text-gray-700',
                                'solicitada' => 'bg-yellow-100 text-yellow-700',
                                'verificando' => 'bg-yellow-100 text-yellow-700',
                                'lista' => 'bg-blue-100 text-blue-700',
                                'descargando' => 'bg-blue-100 text-blue-700',
                                'completada' => 'bg-green-100 text-green-700',
                                'error' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $colores[$solicitud->estado] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($solicitud->estado) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $solicitud->cfdis_procesados }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-accent">No hay solicitudes de descarga recientes.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
