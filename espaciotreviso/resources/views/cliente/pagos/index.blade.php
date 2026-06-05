@extends('layouts.cliente')
@section('title', 'Complementos de Pago')

@section('content')
<div class="bg-white rounded-xl border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">UUID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Emisor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Fecha</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-accent uppercase">Monto</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-accent uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($cfdis as $cfdi)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="text-xs font-mono text-gray-900">{{ \Illuminate\Support\Str::limit($cfdi->uuid, 20) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $cfdi->nombre_emisor ?: $cfdi->rfc_emisor }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $cfdi->fecha_emision->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right font-mono font-medium text-gray-900">${{ number_format($cfdi->monto_total, 2) }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('cliente.facturas.show', $cfdi) }}" class="p-2 text-gray-400 hover:text-primary rounded-lg hover:bg-gray-100 transition-colors">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </a>
                            <a href="{{ route('cliente.facturas.download', $cfdi) }}" class="p-2 text-gray-400 hover:text-primary rounded-lg hover:bg-gray-100 transition-colors">
                                <span class="material-symbols-outlined text-lg">download</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-accent">
                        <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">payments</span>
                        <p>No hay complementos de pago.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cfdis->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">{{ $cfdis->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
