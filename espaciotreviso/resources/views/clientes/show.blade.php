@extends('layouts.sidebar')
@section('title','Cliente')
@section('content')
<div class="space-y-4">
  <div class="flex items-center gap-3">
    <a href="{{ route('clientes.index') }}" class="flex items-center gap-1 text-sm text-accent hover:text-primary transition-colors">
      <span class="material-symbols-outlined text-base">arrow_back</span> Clientes
    </a>
    <span class="text-gray-300">/</span>
    <span class="text-sm font-medium">{{ $cliente->NombreCliente }}</span>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border shadow-sm p-6 space-y-3">
      <h2 class="font-bold text-lt-text dark:text-dk-text">{{ $cliente->NombreCliente }}</h2>
      <dl class="space-y-2 text-sm">
        <div class="flex justify-between"><dt class="text-accent">RFC</dt><dd class="font-mono font-medium">{{ $cliente->RFCCliente }}</dd></div>
        <div class="flex justify-between"><dt class="text-accent">Contacto</dt><dd>{{ $cliente->ContactoCliente }}</dd></div>
        <div class="flex justify-between"><dt class="text-accent">Teléfono</dt><dd>{{ $cliente->TelefonoCliente }}</dd></div>
        <div class="flex justify-between"><dt class="text-accent">Empleado</dt><dd>{{ $cliente->empleado->NombreEmpleado ?? '-' }}</dd></div>
      </dl>
      @if($cliente->bancos->count())
      <div class="pt-3 border-t border-lt-border dark:border-dk-border">
        <p class="text-xs font-semibold text-accent uppercase mb-2">Cuentas bancarias</p>
        <ul class="space-y-1">
          @foreach($cliente->bancos as $banco)
          <li class="flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-base text-primary">account_balance</span>
            {{ $banco->NombreBanco }} — *{{ $banco->TerminacionBancoCliente }}
          </li>
          @endforeach
        </ul>
      </div>
      @endif
    </div>

    <div class="lg:col-span-2 bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border shadow-sm overflow-hidden">
      <div class="px-5 py-3 border-b border-lt-border dark:border-dk-border">
        <h3 class="font-semibold text-sm text-lt-text dark:text-dk-text">Últimos CFDI's</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-lt-bg dark:bg-dk-input text-xs text-accent uppercase tracking-wide border-b border-lt-border dark:border-dk-border">
            <tr>
              <th class="px-4 py-3 text-left">Fecha</th><th class="px-4 py-3 text-left">UUID</th>
              <th class="px-4 py-3 text-left">Emisor</th><th class="px-4 py-3 text-right">Monto</th>
              <th class="px-4 py-3 text-center">Tipo</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-lt-border dark:divide-dk-border">
            @forelse($xmlsRecientes as $xml)
            <tr class="hover:bg-primary/10 transition-colors">
              <td class="px-4 py-3 text-xs whitespace-nowrap">{{ $xml->FechaEmisionXML }}</td>
              <td class="px-4 py-3 font-mono text-xs text-accent">{{ substr($xml->UUID,0,16) }}…</td>
              <td class="px-4 py-3 text-xs">{{ $xml->EmisorXML }}</td>
              <td class="px-4 py-3 text-right font-medium text-primary">${{ number_format($xml->MontoPagoXML,2) }}</td>
              <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600">{{ strtoupper($xml->TipoXML??'?') }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-accent">Sin CFDI's</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection