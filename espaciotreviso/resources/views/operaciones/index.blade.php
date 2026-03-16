@extends('layouts.sidebar')
@section('title','Operaciones sin CFDI')
@section('content')
<div class="space-y-4">
  <h1 class="text-xl font-bold text-lt-text dark:text-dk-text flex items-center gap-2">
    <span class="material-symbols-outlined text-primary">swap_horiz</span> Operaciones sin CFDI
  </h1>
  <form method="GET" class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-4 shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap lg:items-end gap-3">
      <div class="flex flex-col gap-1">
  <label class="text-xs font-medium text-accent">Cliente</label>
  <select name="cliente" class="form-select rounded-lg border-lt-border dark:border-dk-border text-sm h-9 w-full lg:w-auto bg-lt-surface dark:bg-dk-surface text-lt-text dark:text-dk-text focus:ring-primary focus:border-primary">
    <option value="">— Todos —</option>
    @foreach($clientes as $c)
      <option value="{{ $c->IDCliente }}" {{ request('cliente')==$c->IDCliente?'selected':'' }}>{{ $c->NombreCliente }}</option>
    @endforeach
  </select>
</div>
      <button class="h-9 px-4 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary-hover transition-colors flex items-center justify-center gap-1 w-full lg:w-auto sm:col-span-2 lg:col-auto">
        <span class="material-symbols-outlined text-base">filter_list</span> Filtrar
      </button>
    </div>
  </form>
  <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-lt-bg dark:bg-dk-input text-xs text-accent uppercase tracking-wide border-b border-lt-border dark:border-dk-border">
          <tr>
            <th class="px-4 py-3 text-left">Fecha</th>
            <th class="px-4 py-3 text-left">Cliente</th>
            <th class="px-4 py-3 text-left">Descripción</th>
            <th class="px-4 py-3 text-right">Monto</th>
            <th class="px-4 py-3 text-left">Banco origen</th>
            <th class="px-4 py-3 text-left">Banco destino</th>
            <th class="px-4 py-3 text-center">Contabilizado</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-lt-border dark:divide-dk-border">
          @forelse($operaciones as $op)
          <tr class="hover:bg-primary/10 transition-colors">
            <td class="px-4 py-3 text-xs whitespace-nowrap">{{$op->FechaOperacionN}}</td>
            <td class="px-4 py-3 text-xs">{{$op->cliente->NombreCliente??'-'}}</td>
            <td class="px-4 py-3 text-xs">{{$op->DescripcionOperacionN}}</td>
            <td class="px-4 py-3 text-right font-medium">${{ number_format($op->MontoOperacionN,2) }}</td>
            <td class="px-4 py-3 text-xs">{{$op->BancoOrigen}}</td>
            <td class="px-4 py-3 text-xs">{{$op->BancoDestino}}</td>
            <td class="px-4 py-3 text-center">
              @if($op->Contabilizado==='S')
                <span class="inline-flex items-center gap-1 text-xs text-green-600"><span class="material-symbols-outlined text-sm">check_circle</span></span>
              @else
                <span class="inline-flex items-center gap-1 text-xs text-orange-500"><span class="material-symbols-outlined text-sm">pending</span></span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="px-4 py-8 text-center text-accent">Sin registros</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-4 py-3 border-t border-lt-border dark:border-dk-border">{{ $operaciones->links() }}</div>
  </div>
</div>
@endsection