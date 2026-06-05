@extends('layouts.admin')
@section('title', 'Clientes')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-accent">{{ $clientes->total() }} clientes registrados</p>
    <a href="{{ route('admin.clientes.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
        <span class="material-symbols-outlined text-lg">add</span>
        Agregar Cliente
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">RFC</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Razon Social</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">e.firma</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Portal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-accent uppercase">Estado</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-accent uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($clientes as $cliente)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-mono text-sm text-gray-900">{{ $cliente->rfc }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $cliente->razon_social }}</td>
                    <td class="px-6 py-4">
                        @if($cliente->tieneEfirmaValida())
                            <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                <span class="material-symbols-outlined text-xs">check_circle</span>
                                Vigente ({{ $cliente->efirma_vigencia->format('d/m/Y') }})
                            </span>
                        @elseif($cliente->cer_path)
                            <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                <span class="material-symbols-outlined text-xs">error</span>
                                Vencida
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-500">
                                <span class="material-symbols-outlined text-xs">remove_circle</span>
                                Sin e.firma
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($cliente->clienteAuth)
                            <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                <span class="material-symbols-outlined text-xs">person</span>
                                {{ $cliente->clienteAuth->email }}
                            </span>
                        @else
                            <span class="text-xs text-accent">Sin acceso</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $cliente->activo ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $cliente->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.clientes.edit', $cliente) }}" class="p-2 text-gray-400 hover:text-primary rounded-lg hover:bg-gray-100 transition-colors" title="Editar">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </a>
                            <form method="POST" action="{{ route('admin.clientes.destroy', $cliente) }}" onsubmit="return confirm('Estas seguro de eliminar este cliente y todos sus datos?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 rounded-lg hover:bg-red-50 transition-colors" title="Eliminar">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-accent">No hay clientes registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($clientes->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $clientes->links() }}
    </div>
    @endif
</div>
@endsection
