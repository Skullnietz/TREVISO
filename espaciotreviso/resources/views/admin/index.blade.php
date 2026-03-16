@extends('layouts.sidebar')
@section('title','Administración')
@section('content')
<div class="space-y-4">
  <h1 class="text-xl font-bold text-lt-text dark:text-dk-text flex items-center gap-2">
    <span class="material-symbols-outlined text-primary">admin_panel_settings</span> Panel de Administración
  </h1>
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-md">
    <a href="{{ route('admin.empleados') }}" class="flex items-center gap-3 bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-5 shadow-sm hover:border-primary hover:shadow-md transition-all group">
      <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
        <span class="material-symbols-outlined">group</span>
      </div>
      <span class="font-medium text-lt-text dark:text-dk-text">Empleados</span>
    </a>
    <a href="{{ route('admin.clientes') }}" class="flex items-center gap-3 bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-5 shadow-sm hover:border-primary hover:shadow-md transition-all group">
      <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
        <span class="material-symbols-outlined">business</span>
      </div>
      <span class="font-medium text-lt-text dark:text-dk-text">Clientes</span>
    </a>
  </div>
</div>
@endsection