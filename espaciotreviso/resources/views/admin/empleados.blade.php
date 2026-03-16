@extends('layouts.sidebar')
@section('title','Empleados')
@section('content')
<div class="space-y-4">
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.index') }}" class="flex items-center gap-1 text-sm text-accent hover:text-primary"><span class="material-symbols-outlined text-base">arrow_back</span> Admin</a>
    <span class="text-gray-300">/</span>
    <h1 class="text-xl font-bold text-lt-text dark:text-dk-text">Empleados</h1>
  </div>
  <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-lt-bg dark:bg-dk-input text-xs text-accent uppercase tracking-wide border-b border-lt-border dark:border-dk-border">
          <tr>
            <th class="px-4 py-3 text-left">Nombre</th><th class="px-4 py-3 text-left">Correo</th>
            <th class="px-4 py-3 text-left">Teléfono</th><th class="px-4 py-3 text-left">Usuario</th>
            <th class="px-4 py-3 text-center">Rol</th><th class="px-4 py-3 text-center">Activo</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-lt-border dark:divide-dk-border">
          @forelse($empleados as $e)
          <tr class="hover:bg-primary/10 transition-colors">
            <td class="px-4 py-3 font-medium">{{ $e->NombreEmpleado }} {{ $e->ApellidoPEmpleado }} {{ $e->ApellidoMEmpleado }}</td>
            <td class="px-4 py-3 text-xs">{{ $e->CorreoEmpleado }}</td>
            <td class="px-4 py-3 text-xs">{{ $e->TelefonoEmpleado }}</td>
            <td class="px-4 py-3 text-xs font-mono">{{ $e->usuario->NickUsuarioEmpleado ?? '-' }}</td>
            <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 rounded-full text-xs {{ $e->usuario->IDRol==1 ? 'bg-primary/10 text-primary' : 'bg-gray-100 text-gray-600' }}">{{ $e->usuario->IDRol==1 ? 'Admin' : 'Colaborador' }}</span></td>
            <td class="px-4 py-3 text-center">
              @if($e->ActivoEmpleado==='A')<span class="material-symbols-outlined text-sm text-green-500">check_circle</span>
              @else<span class="material-symbols-outlined text-sm text-red-400">cancel</span>@endif
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="px-4 py-8 text-center text-accent">Sin empleados</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection