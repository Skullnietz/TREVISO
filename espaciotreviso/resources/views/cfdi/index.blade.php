@extends('layouts.sidebar')
@section('title',"CFDI's — Treviso")
@section('content')

<div class="space-y-4">
  <div class="flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-xl font-bold text-lt-text dark:text-dk-text flex items-center gap-2">
      <span class="material-symbols-outlined text-primary">description</span> Explorador de CFDI's
    </h1>
  </div>

  {{-- Filtros --}}
  <form method="GET" class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-4 shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap lg:items-end gap-3">
      <div class="flex flex-col gap-1">
        <label class="text-xs font-medium text-accent">Cliente</label>
        <select name="cliente" class="form-select rounded-lg border-lt-border dark:border-dk-border text-sm h-9 w-full lg:w-auto bg-lt-surface dark:bg-dk-surface text-lt-text dark:text-dk-text focus:ring-primary focus:border-primary">
          <option value="">— Todos —</option>
          @foreach($clientes as $c)
            <option value="{{ $c->IDCliente }}" {{ $clienteId==$c->IDCliente?'selected':'' }}>{{ $c->NombreCliente }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex flex-col gap-1">
        <label class="text-xs font-medium text-accent">Mes</label>
        <select name="mes" class="form-select rounded-lg border-lt-border dark:border-dk-border text-sm h-9 w-full lg:w-auto bg-lt-surface dark:bg-dk-surface text-lt-text dark:text-dk-text focus:ring-primary focus:border-primary">
          <option value="">Todos</option>
          @for($m=1;$m<=12;$m++)
            <option value="{{ $m }}" {{ $mes==$m?'selected':'' }}>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>
          @endfor
        </select>
      </div>
      <div class="flex flex-col gap-1">
        <label class="text-xs font-medium text-accent">Año</label>
        <input type="number" name="anio" value="{{ $anio }}" class="form-input rounded-lg border-lt-border dark:border-dk-border text-sm h-9 w-full lg:w-24 bg-lt-surface dark:bg-dk-surface text-lt-text dark:text-dk-text focus:ring-primary focus:border-primary">
      </div>
      <div class="flex flex-col gap-1">
        <label class="text-xs font-medium text-accent">Tipo</label>
        <select name="tipo" class="form-select rounded-lg border-lt-border dark:border-dk-border text-sm h-9 w-full lg:w-auto bg-lt-surface dark:bg-dk-surface text-lt-text dark:text-dk-text focus:ring-primary focus:border-primary">
          <option value="">Todos</option>
          <option value="i" {{ $tipo=='i'?'selected':'' }}>Ingresos</option>
          <option value="e" {{ $tipo=='e'?'selected':'' }}>Egresos</option>
          <option value="n" {{ $tipo=='n'?'selected':'' }}>Nómina</option>
        </select>
      </div>
      <button class="h-9 px-4 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary-hover transition-colors flex items-center justify-center gap-1 w-full lg:w-auto sm:col-span-2 lg:col-auto">
        <span class="material-symbols-outlined text-base">search</span> Buscar
      </button>
    </div>
  </form>

  {{-- Tabla --}}
  @if($xmls->count())
  <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-lt-bg dark:bg-dk-input text-xs text-accent uppercase tracking-wide border-b border-lt-border dark:border-dk-border">
          <tr>
            <th class="px-4 py-3 text-left">UUID</th>
            <th class="px-4 py-3 text-left">Emisor</th>
            <th class="px-4 py-3 text-left">Receptor</th>
            <th class="px-4 py-3 text-left">Fecha</th>
            <th class="px-4 py-3 text-right">Monto</th>
            <th class="px-4 py-3 text-center">Tipo</th>
            <th class="px-4 py-3 text-center">Contabilizado</th>
            <th class="px-4 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-lt-border dark:divide-dk-border">
          @foreach($xmls as $xml)
          <tr class="hover:bg-primary/10 transition-colors">
            <td class="px-4 py-3 font-mono text-xs text-accent">{{ substr($xml->UUID,0,18) }}…</td>
            <td class="px-4 py-3 text-xs">{{ $xml->EmisorXML }}</td>
            <td class="px-4 py-3 text-xs">{{ \Illuminate\Support\Str::limit($xml->ReceptorXML,30) }}</td>
            <td class="px-4 py-3 text-xs whitespace-nowrap">{{ $xml->FechaEmisionXML }}</td>
            <td class="px-4 py-3 text-right font-medium">${{ number_format($xml->MontoPagoXML,2) }}</td>
            <td class="px-4 py-3 text-center">
              <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-dk-border dark:text-dk-text">{{ strtoupper($xml->TipoXML ?? '?') }}</span>
            </td>
            <td class="px-4 py-3 text-center">
              @if($xml->ContabilizadoXML === 'S')
                <span class="inline-flex items-center gap-1 text-xs text-green-600"><span class="material-symbols-outlined text-sm">check_circle</span> Sí</span>
              @else
                <span class="inline-flex items-center gap-1 text-xs text-orange-500"><span class="material-symbols-outlined text-sm">pending</span> No</span>
              @endif
            </td>
            <td class="px-4 py-3">
              <a href="{{ route('cfdi.show',$xml->IDXML) }}" class="text-primary hover:text-secondary text-xs font-medium hover:underline">Ver</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="px-4 py-3 border-t border-lt-border dark:border-dk-border">
      {{ $xmls->links() }}
    </div>
  </div>
  @elseif(request('cliente'))
    <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-8 text-center text-accent shadow-sm">
      <span class="material-symbols-outlined text-4xl mb-2 block">inbox</span>
      No se encontraron CFDI's con los filtros seleccionados.
    </div>
  @else
    <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-8 text-center text-accent shadow-sm">
      <span class="material-symbols-outlined text-4xl mb-2 block">search</span>
      Selecciona un cliente para explorar sus CFDI's.
    </div>
  @endif
</div>
@endsection