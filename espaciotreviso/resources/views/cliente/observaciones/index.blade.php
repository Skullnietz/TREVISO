@extends('layouts.cliente')
@section('title', 'Observaciones')

@section('content')
<div class="bg-white rounded-xl border border-gray-200">
    <div class="divide-y divide-gray-100">
        @forelse($observaciones as $obs)
        <div class="px-6 py-4 hover:bg-gray-50 {{ !$obs->leida && $obs->tipo === 'contador' ? 'bg-blue-50/50' : '' }}">
            <div class="flex items-start gap-4">
                <div class="size-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $obs->tipo === 'cliente' ? 'bg-blue-100' : 'bg-green-100' }}">
                    <span class="material-symbols-outlined {{ $obs->tipo === 'cliente' ? 'text-blue-600' : 'text-green-600' }}">
                        {{ $obs->tipo === 'cliente' ? 'person' : 'support_agent' }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm font-medium text-gray-900">{{ $obs->tipo === 'cliente' ? 'Tu' : 'Contador' }}</span>
                        <span class="text-xs text-accent">{{ $obs->created_at->diffForHumans() }}</span>
                        @if(!$obs->leida && $obs->tipo === 'contador')
                            <span class="inline-flex px-1.5 py-0.5 text-xs font-medium rounded bg-blue-100 text-blue-700">Nuevo</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-700">{{ $obs->mensaje }}</p>
                    @if($obs->cfdi)
                    <a href="{{ route('cliente.facturas.show', $obs->cfdi) }}" class="inline-flex items-center gap-1 mt-2 text-xs text-primary hover:text-secondary font-medium">
                        <span class="material-symbols-outlined text-xs">receipt_long</span>
                        Factura: {{ \Illuminate\Support\Str::limit($obs->cfdi->uuid, 16) }} - ${{ number_format($obs->cfdi->monto_total, 2) }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="px-6 py-12 text-center text-accent">
            <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">forum</span>
            <p class="text-base font-medium text-gray-500">No hay observaciones</p>
            <p class="text-sm text-accent mt-1">Las observaciones que hagas sobre tus facturas apareceran aqui.</p>
        </div>
        @endforelse
    </div>
    @if($observaciones->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $observaciones->links() }}
    </div>
    @endif
</div>
@endsection
