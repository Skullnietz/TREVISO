@extends('layouts.sidebar')
@section('title','Admin — Clientes')
@section('content')
<div class="space-y-4">
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.index') }}" class="flex items-center gap-1 text-sm text-accent hover:text-primary"><span class="material-symbols-outlined text-base">arrow_back</span> Admin</a>
    <span class="text-gray-300">/</span>
    <h1 class="text-xl font-bold text-lt-text dark:text-dk-text">Clientes</h1>
  </div>
  <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-lt-bg dark:bg-dk-input text-xs text-accent uppercase tracking-wide border-b border-lt-border dark:border-dk-border">
          <tr>
            <th class="px-4 py-3 text-left">Nombre</th><th class="px-4 py-3 text-left">RFC</th>
            <th class="px-4 py-3 text-left">Contacto</th><th class="px-4 py-3 text-left">Empleado</th>
            <th class="px-4 py-3 text-center">Activo</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-lt-border dark:divide-dk-border">
          @forelse($clientes as $c)
          <tr class="hover:bg-primary/10 transition-colors">
            <td class="px-4 py-3 font-medium">{{ $c->NombreCliente }}</td>
            <td class="px-4 py-3 text-xs font-mono">{{ $c->RFCCliente }}</td>
            <td class="px-4 py-3 text-xs">{{ $c->ContactoCliente }}</td>
            <td class="px-4 py-3 text-xs">{{ $c->empleado->NombreEmpleado ?? '-' }}</td>
            <td class="px-4 py-3 text-center">
              @if($c->ActivoCliente==='A')<span class="material-symbols-outlined text-sm text-green-500">check_circle</span>
              @else<span class="material-symbols-outlined text-sm text-red-400">cancel</span>@endif
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="px-4 py-8 text-center text-accent">Sin clientes</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-4 py-3 border-t border-lt-border dark:border-dk-border">{{ $clientes->links() }}</div>
  </div>
</div>
@endsection