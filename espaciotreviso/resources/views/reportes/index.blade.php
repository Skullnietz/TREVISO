@extends('layouts.sidebar')
@section('title','Reportes')
@section('content')
<div class="space-y-6">
  <h1 class="text-xl font-bold text-lt-text dark:text-dk-text flex items-center gap-2">
    <span class="material-symbols-outlined text-primary">bar_chart</span> Reportes
  </h1>
  <form method="GET" class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-4 shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap lg:items-end gap-3">
      <div class="flex flex-col gap-1">
        <label class="text-xs font-medium text-accent">Mes</label>
        <select name="mes" class="form-select rounded-lg border-lt-border dark:border-dk-border text-sm h-9 w-full lg:w-auto bg-lt-surface dark:bg-dk-surface text-lt-text dark:text-dk-text focus:ring-primary focus:border-primary">
          @for($m=1;$m<=12;$m++)
            <option value="{{ $m }}" {{ $mes==$m?'selected':'' }}>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>
          @endfor
        </select>
      </div>
      <div class="flex flex-col gap-1">
        <label class="text-xs font-medium text-accent">Año</label>
        <input type="number" name="anio" value="{{ $anio }}" class="form-input rounded-lg border-lt-border dark:border-dk-border text-sm h-9 w-full lg:w-24 bg-lt-surface dark:bg-dk-surface text-lt-text dark:text-dk-text focus:ring-primary focus:border-primary">
      </div>
      <button class="h-9 px-4 bg-primary text-white text-sm font-medium rounded-lg hover:bg-secondary transition-colors">Ver</button>
    </div>
  </form>

  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-5 shadow-sm text-center">
      <p class="text-2xl font-bold text-primary">{{ number_format($xmlsMes) }}</p>
      <p class="text-xs text-accent mt-1">CFDI's en el mes</p>
    </div>
    <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-5 shadow-sm text-center">
      <p class="text-2xl font-bold text-primary">${{ number_format($montoMes,2) }}</p>
      <p class="text-xs text-accent mt-1">Monto total CFDI's</p>
    </div>
    <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-5 shadow-sm text-center">
      <p class="text-2xl font-bold text-green-600">${{ number_format($depositosMes,2) }}</p>
      <p class="text-xs text-accent mt-1">Depósitos</p>
    </div>
    <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-5 shadow-sm text-center">
      <p class="text-2xl font-bold text-orange-500">${{ number_format($reembolsosMes,2) }}</p>
      <p class="text-xs text-accent mt-1">Reembolsos</p>
    </div>
  </div>

  <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border shadow-sm overflow-hidden">
    <div class="px-5 py-3 border-b border-lt-border dark:border-dk-border">
      <h3 class="font-semibold text-sm text-lt-text dark:text-dk-text">Detalle por cliente</h3>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-lt-bg dark:bg-dk-input text-xs text-accent uppercase tracking-wide border-b border-lt-border dark:border-dk-border">
          <tr>
            <th class="px-4 py-3 text-left">Cliente</th>
            <th class="px-4 py-3 text-center">CFDI's</th>
            <th class="px-4 py-3 text-right">Monto</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-lt-border dark:divide-dk-border">
          @forelse($porCliente as $row)
          <tr class="hover:bg-primary/10 transition-colors">
            <td class="px-4 py-3">{{ $row->cliente->NombreCliente ?? $row->IDCliente }}</td>
            <td class="px-4 py-3 text-center font-medium">{{ $row->total }}</td>
            <td class="px-4 py-3 text-right font-medium text-primary">${{ number_format($row->monto,2) }}</td>
          </tr>
          @empty
          <tr><td colspan="3" class="px-4 py-8 text-center text-accent">Sin datos para el periodo</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection