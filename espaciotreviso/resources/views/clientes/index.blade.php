@extends('layouts.sidebar')
@section('title','Clientes')
@section('content')
<div class="space-y-4">
  <h1 class="text-xl font-bold text-lt-text dark:text-dk-text flex items-center gap-2">
    <span class="material-symbols-outlined text-primary">business</span> Clientes
  </h1>
  <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-lt-bg dark:bg-dk-input text-xs text-accent uppercase tracking-wide border-b border-lt-border dark:border-dk-border">
          <tr>
            <th class="px-4 py-3 text-left">Nombre</th><th class="px-4 py-3 text-left">RFC</th>
            <th class="px-4 py-3 text-left">Contacto</th><th class="px-4 py-3 text-left">Teléfono</th>
            <th class="px-4 py-3 text-left">Empleado</th><th class="px-4 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-lt-border dark:divide-dk-border">
          @forelse($clientes as $c)
          <tr class="hover:bg-primary/10 transition-colors">
            <td class="px-4 py-3 font-medium">{{ $c->NombreCliente }}</td>
            <td class="px-4 py-3 text-xs font-mono">{{ $c->RFCCliente }}</td>
            <td class="px-4 py-3 text-xs">{{ $c->ContactoCliente }}</td>
            <td class="px-4 py-3 text-xs">{{ $c->TelefonoCliente }}</td>
            <td class="px-4 py-3 text-xs">{{ $c->empleado->NombreEmpleado ?? '-' }}</td>
            <td class="px-4 py-3">
              <a href="{{ route('clientes.show',$c->IDCliente) }}" class="text-xs text-primary hover:text-secondary font-medium hover:underline flex items-center gap-0.5">
                Ver <span class="material-symbols-outlined text-sm">chevron_right</span>
              </a>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="px-4 py-8 text-center text-accent">Sin clientes</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-4 py-3 border-t border-lt-border dark:border-dk-border">{{ $clientes->links() }}</div>
  </div>
</div>
@endsection