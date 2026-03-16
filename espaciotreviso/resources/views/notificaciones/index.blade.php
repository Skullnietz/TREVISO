@extends('layouts.sidebar')
@section('title','Notificaciones')
@section('content')
<div class="space-y-4">
  <h1 class="text-xl font-bold text-lt-text dark:text-dk-text flex items-center gap-2">
    <span class="material-symbols-outlined text-primary">notifications</span> Notificaciones
  </h1>
  @forelse($notificaciones as $n)
  <div class="flex gap-4 bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-4 shadow-sm">
    <div class="size-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
      <span class="material-symbols-outlined">notifications</span>
    </div>
    <div>
      <p class="text-sm text-lt-text dark:text-dk-text">{{ $n->DescripcionNotificacion }}</p>
      <p class="text-xs text-accent mt-1">{{ $n->FechaNotificacion }} — caduca: {{ $n->CaducidadFechaNotificacion }}</p>
    </div>
  </div>
  @empty
  <div class="bg-lt-surface dark:bg-dk-surface rounded-xl border border-lt-border dark:border-dk-border p-10 text-center shadow-sm">
    <span class="material-symbols-outlined text-4xl text-green-400 block mb-2">check_circle</span>
    <p class="text-accent text-sm">No tienes notificaciones pendientes.</p>
  </div>
  @endforelse
</div>
@endsection