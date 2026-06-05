@extends('layouts.admin')
@section('title', 'Descargas SAT')

@section('content')
<!-- Solicitar descarga -->
<div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Solicitar Descarga Manual</h2>
    <form method="POST" action="{{ route('admin.descargas.solicitar') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-xs font-medium text-accent mb-1">Cliente</label>
                <select name="cliente_id" required class="form-select w-full rounded-lg border-gray-300 text-sm">
                    <option value="">Seleccionar...</option>
                    @foreach($clientes as $c)
                        <option value="{{ $c->id }}">{{ $c->razon_social }} ({{ $c->rfc }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-accent mb-1">Fecha Inicio</label>
                <input name="fecha_inicio" type="date" required class="form-input w-full rounded-lg border-gray-300 text-sm"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-accent mb-1">Fecha Fin</label>
                <input name="fecha_fin" type="date" required class="form-input w-full rounded-lg border-gray-300 text-sm"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-accent mb-1">Tipo</label>
                <select name="tipo" required class="form-select w-full rounded-lg border-gray-300 text-sm">
                    <option value="emitida">Emitidas</option>
                    <option value="recibida">Recibidas</option>
                </select>
            </div>
        </div>
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
            <span class="material-symbols-outlined text-lg">cloud_download</span>
            Solicitar Descarga
        </button>
    </form>
</div>

<!-- Historial -->
<div class="bg-white rounded-xl border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Historial de Solicitudes</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Periodo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Progreso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Origen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($solicitudes as $s)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $s->cliente->razon_social ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $s->tipo === 'emitida' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                            {{ ucfirst($s->tipo) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $s->fecha_inicio->format('d/m/Y') }} - {{ $s->fecha_fin->format('d/m/Y') }}</td>
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
                        <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $colores[$s->estado] ?? '' }}">
                            {{ ucfirst($s->estado) }}
                        </span>
                        @if($s->error_mensaje)
                            <p class="text-xs text-red-500 mt-1">{{ \Illuminate\Support\Str::limit($s->error_mensaje, 50) }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($s->paquetes_total > 0)
                            <div class="w-24">
                                <div class="flex items-center justify-between text-xs text-accent mb-1">
                                    <span>{{ $s->paquetes_descargados }}/{{ $s->paquetes_total }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-primary h-1.5 rounded-full" style="width: {{ ($s->paquetes_descargados / max($s->paquetes_total, 1)) * 100 }}%"></div>
                                </div>
                            </div>
                        @else
                            <span class="text-xs text-accent">-</span>
                        @endif
                        <p class="text-xs text-accent mt-1">{{ $s->cfdis_procesados }} CFDIs</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs {{ $s->automatica ? 'text-accent' : 'text-primary font-medium' }}">
                            {{ $s->automatica ? 'Automatica' : 'Manual' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-600">{{ $s->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-accent">No hay solicitudes de descarga.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($solicitudes->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $solicitudes->links() }}
    </div>
    @endif
</div>
@endsection
