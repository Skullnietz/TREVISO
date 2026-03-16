@extends('layouts.sidebar')
@section('title','Detalle CFDI')
@section('content')
<div class="space-y-4">
  <div class="flex items-center gap-3">
    <a href="{{ route('cfdi.index') }}" class="flex items-center gap-1 text-sm text-accent hover:text-primary transition-colors">
      <span class="material-symbols-outlined text-base">arrow_back</span> Volver
    </a>
    <span class="text-gray-300">/</span>
    <span class="text-sm font-medium text-lt-text dark:text-dk-text">CFDI #{{ $xml->IDXML }}</span>
  </div>

  <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border shadow-sm overflow-hidden">
    <div class="bg-primary px-6 py-4">
      <h2 class="text-white font-bold text-lg">CFDI #{{ $xml->IDXML }}</h2>
      <p class="text-white/70 text-sm font-mono mt-0.5">{{ $xml->UUID }}</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x divide-lt-border dark:divide-dk-border">
      <div class="p-6 space-y-3">
        <dl class="space-y-3 text-sm">
          <div class="flex justify-between"><dt class="text-accent">Serie / Folio</dt><dd class="font-medium">{{ $xml->SerieXML }}/{{ $xml->FolioXML }}</dd></div>
          <div class="flex justify-between"><dt class="text-accent">Emisor</dt><dd class="font-medium">{{ $xml->EmisorXML }}</dd></div>
          <div class="flex justify-between"><dt class="text-accent">Receptor</dt><dd class="font-medium">{{ $xml->ReceptorXML }}</dd></div>
          <div class="flex justify-between"><dt class="text-accent">Fecha emisión</dt><dd class="font-medium">{{ $xml->FechaEmisionXML }}</dd></div>
          <div class="flex justify-between"><dt class="text-accent">Cliente</dt><dd class="font-medium">{{ $xml->cliente->NombreCliente ?? '-' }}</dd></div>
        </dl>
      </div>
      <div class="p-6 space-y-3">
        <dl class="space-y-3 text-sm">
          <div class="flex justify-between"><dt class="text-accent">Monto</dt><dd class="font-bold text-lg text-primary">${{ number_format($xml->MontoPagoXML,2) }}</dd></div>
          <div class="flex justify-between"><dt class="text-accent">Tipo</dt><dd><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">{{ strtoupper($xml->TipoXML ?? '-') }}</span></dd></div>
          <div class="flex justify-between"><dt class="text-accent">Contabilizado</dt>
            <dd>@if($xml->ContabilizadoXML==='S')<span class="text-green-600 font-medium">Sí</span>@else<span class="text-orange-500 font-medium">No</span>@endif</dd>
          </div>
          <div class="flex justify-between"><dt class="text-accent">Saldado</dt>
            <dd>@if($xml->SaldadoXML==='S')<span class="text-green-600 font-medium">Sí</span>@else<span class="text-orange-500 font-medium">No</span>@endif</dd>
          </div>
          <div class="flex justify-between"><dt class="text-accent">Forma de pago</dt><dd class="font-medium">{{ $xml->FormaPagoXML ?? '-' }}</dd></div>
        </dl>
      </div>
    </div>
    @if($xml->RutaCarpetaXML)
    <div class="px-6 py-4 border-t border-lt-border dark:border-dk-border bg-lt-bg dark:bg-dk-input">
      <p class="text-xs text-accent"><span class="font-medium">Ruta:</span> <code class="font-mono">{{ $xml->RutaCarpetaXML }}</code></p>
    </div>
    @endif
  </div>
</div>
@endsection